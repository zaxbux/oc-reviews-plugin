<?php return [
    'plugin' => [
        'name' => 'Reviews',
        'description' => '',
    ],
    'permissions' => [
        'access_settings' => 'Access Settings',
        'manage_reviews' => 'Manage Reviews',
    ],
    'settings' => [
        'label' => 'Reviews',
        'description' => 'Manage settings for reviews.',
        'category' => 'Reviews',
        'fields' => [
            'moderatorGroup' => [
                'label' => 'Moderator User Group',
                'comment' => 'Choose a user group to receive notifications of new reviews. The user group you create must have a unique code.',
            ],
            'recaptcha_siteKey' => [
                'label' => 'reCAPTCHA v2 Site Key',
                'comment' => '<a href="https://www.google.com/recaptcha/admin" target="_blank" rel="noopener">Obtain your Google reCAPTCHA keys here.</a>',
            ],
            'recaptcha_secretKey' => [
                'label' => 'reCAPTCHA v2 Secret Key',
                'comment' => '<a href="https://www.google.com/recaptcha/admin" target="_blank" rel="noopener">Obtain your Google reCAPTCHA keys here.</a>',
            ],
        ],
    ],
    'fields' => [
        'review' => [
            'name' => [
                'label' => 'Name',
                'comment' => 'The guest\'s name. Only the first letter of the last name(s) will be public.',
            ],
            'email' => [
                'label' => 'Email Address',
                'comment' => 'The guest\'s email address.',
            ],
            'country' => [
                'label' => 'Country',
                'comment' => 'The guest\'s country of residence.',
            ],
            'check_in' => [
                'label' => 'Check-In Date',
                'comment' => 'The check-in date of the guest\'s stay.',
            ],
            'rating' => [
                'label' => 'Rating',
                'comment' => 'The guest\'s overall rating (out of 5). Set to 0 to hide stars.',
            ],
            'title' => [
                'label' => 'Review Title',
                'comment' => '',
            ],
            'content' => [
                'label' => 'Review Content',
                'comment' => 'The guest\'s review.',
            ],
            'approved' => [
                'label' => 'Approved',
                'comment' => 'Mark the review as approved.',
            ],
            'visible' => [
                'label' => 'Visible',
                'comment' => 'Mark the review as public.',
            ],
            'featured' => [
                'label' => 'Featured',
                'comment' => 'Mark the review as featured.',
            ],
            'reply_content' => [
                'label' => 'Your Reply',
                'comment' => 'Your reply to the guest\'s review.',
            ],
            'created_at' => [
                'label' => 'Submitted',
            ],
            '_replied' => [
                'label' => 'Replied',
            ],
        ],
    ],
    'tabs' => [
        'response' => 'Response',
    ],
    'controllers' => [
        'reviews' => [
            'list_title' => 'Reviews',
            'form_title' => 'Review',
        ],
    ],
    'components' => [
        'reviews' => [
            'name' => 'Reviews',
            'description' => 'Display reviews.',
        ],
        'reviewSubmit' => [
            'name' => 'Submit Form',
            'description' => 'Display a review submit form.',
        ],
        'reviewSummary' => [
            'name' => 'Review Summary',
            'description' => 'Display the average rating.',
        ],
    ],
    'properties' => [
        'pageNumber' => [
            'title' => 'Page Number',
            'description' => ''
        ],
        'reviewsPerPage' => [
            'title' => 'Reviews Per Page',
            'description' => 'Number of reviews per page. Set to 0 to show all.',
            'validation' => 'Must be a positive integer',
        ],
        'showFeatured' => [
            'title' => 'Only Featured',
            'description' => 'Only show reviews marked as featured.',
        ],
    ],
];