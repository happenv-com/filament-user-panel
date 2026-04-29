<?php

return [
    'user_menu_label' => 'My Profile',
    'password_confirm' => [
        'heading' => 'Confirm password',
        'description' => 'Please confirm your password to complete this action.',
        'current_password' => 'Current password',
    ],
    'profile' => [
        'account' => 'Account',
        'profile' => 'Profile',
        'my_profile' => 'My Profile',
        'subheading' => 'Manage your user profile here.',
        'personal_info' => [
            'heading' => 'Personal Information',
            'subheading' => 'Manage your personal information.',
            'submit' => [
                'label' => 'Update',
            ],
            'notify' => 'Profile updated successfully!',
        ],
        'password' => [
            'heading' => 'Password',
            'subheading' => 'Must be at least 8 characters long.',
            'submit' => [
                'label' => 'Update',
            ],
            'notify' => 'Password updated successfully!',
        ],
        'browser_sessions' => [
            'heading' => 'Browser Sessions',
            'subheading' => 'Manage your active sessions.',
            'label' => 'Browser Sessions',
            'content' => 'If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.',
            'device' => 'This device',
            'last_active' => 'Last active',
            'logout_other_sessions' => 'Log Out Other Browser Sessions',
            'logout_heading' => 'Log Out Other Browser Sessions',
            'logout_description' => 'Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.',
            'logout_action' => 'Log Out Other Browser Sessions',
            'incorrect_password' => 'The password you entered was incorrect. Please try again.',
            'logout_success' => 'All other browser sessions have been logged out successfully.',
        ],
        'sanctum' => [
            'title' => 'API Tokens',
            'description' => 'Manage API tokens that allow third-party services to access this application on your behalf.',
            'create' => [
                'notify' => 'Token created successfully!',
                'message' => 'Your token is only shown once upon creation. If you lose your token, you will need to delete it and create a new one.',
                'submit' => [
                    'label' => 'Create',
                ],
            ],
            'update' => [
                'notify' => 'Token updated successfully!',
                'submit' => [
                    'label' => 'Update',
                ],
            ],
            'copied' => [
                'label' => 'I have copied my token',
            ],
        ],
    ],
    'clipboard' => [
        'link' => 'Copy to clipboard',
        'tooltip' => 'Copied!',
    ],
    'fields' => [
        'avatar' => 'Avatar',
        'email' => 'Email',
        'login' => 'Login',
        'name' => 'Name',
        'password' => 'Password',
        'password_confirm' => 'Password confirm',
        'new_password' => 'New password',
        'new_password_confirmation' => 'Confirm password',
        'token_name' => 'Token name',
        'token_expiry' => 'Token expiry',
        'abilities' => 'Abilities',
        'created' => 'Created',
        'expires' => 'Expires',
        'never_expires' => 'Never expires',
    ],
    'or' => 'Or',
    'cancel' => 'Cancel',
];
