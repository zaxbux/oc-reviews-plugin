<?php namespace Zaxbux\Reviews\Models;

use Model;
use Mail;
use Request;
use Backend;
use BackendAuth;
use Zaxbux\Reviews\Models\Settings;
use Backend\Models\UserGroup;
use League\ISO3166\ISO3166;
use Spatie\SchemaOrg\Schema;

/**
 * Model
 */
class Review extends Model {
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;

    protected $guarded = [
        'id'
    ];

    protected $dates = ['deleted_at'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'zaxbux_reviews_reviews';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => ['required'],
        'email' => ['email'],
        'country' => ['required', 'country_alpha2'],
        'check_in' => ['required', 'date'],
        'rating' => ['required', 'integer', 'min:0', 'max:5'],
        'title' => ['string'],
        'content' => ['required', 'string', 'min:100', 'max:4000'],
        'approved' => ['boolean'],
        'visible' => ['boolean'],
        'featured' => ['boolean'],
        'reply_content' => ['string'],
    ];

    public $customMessages = [
        "name.required" => 'Please provide your name.',
        "email.required" => 'Please provide a valid email address.',
        "country.required" => 'Please select a country.',
        "check_in.required" => 'Please provide a valid check-in date.',
        "rating.required" => 'Please provide a rating.',
        "title.required" => 'Please provide a title.',
        "content.required" => 'Please provide a review.',
        "content.min" => 'Your review must be longer than 100 characters.',
        "content.max" => 'Your review must be shorter than 4000 characters.',
    ];

    public function scopeIsPublished($query) {
        return $query->where('visible', true)->where('approved', true);
    }

    public function scopeIsFeatured($query) {
        return $query->where('featured', true);
    }

    public function getPublicName() {
        $names = \explode(' ', $this->name);

        $publicName = $names[0];

        for ($i = 1; $i < count($names); $i++) {
            $publicName .= ' ' . \substr($names[$i], 0, 1) . '.';
        }

        return $publicName;
    }

    public function getCountryName() {
		return (new ISO3166)->alpha2($this->country)['name'];
    }
    
    public function getCountryOptions() {
        $countries = [];

        foreach ((new ISO3166)->all() as $country) {
            $countries[$country['alpha2']] = [$country['name'], 'flag-'.strtolower($country['alpha2'])];
        }

        return $countries;
    }

    public function afterCreate() {
        // Skip sending for reviews created by authenticated users
        if (BackendAuth::getUser()) {
            return;
        }

        $group = UserGroup::where('code', Settings::get('moderatorGroup'))->first();

        // Skip sending if no users
        if (!isset($group->users)) {
            return;
        }

        $vars = [
            'review'  => $this,
            'ip'      => Request::ip(),
            'backend' => Backend::url('backend'),
        ];

        Mail::sendTo($group->users, 'zaxbux.reviews::mail.new-review', $vars);
    }

    public function getSchemaOrg() {
        return Schema::review()
            ->name($this->title)
            ->author(Schema::person()->name($this->getPublicName()))
            ->datePublished($this->created_at)
            ->reviewBody($this->content)
            ->reviewRating(Schema::rating()
                ->bestRating(5)
                ->ratingvalue($this->rating)
                ->worstRating(1)
        );
    }
}
