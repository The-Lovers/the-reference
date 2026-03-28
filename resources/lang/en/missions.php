<?php
    return [
        'index' => [
            'title' => "Title",
            'description' => "Description",
            'status' => [
                'title' => "Status",
                '0' => "Draft",
                '1' => "Published",
                'confirm' => "Do you really want to change the status of this mission ?",
                'success' => "Status changed successfully!",
            ],
            'featured' => [
                'title' => "Featured",
                '0' => "No",
                '1' => "Yes",
                'confirm' => "Do you really want to change the featured status of this mission ?",
                'success' => "Featured status changed successfully!",
            ],
            'created-by' => "Created by",
            'not-found' => "No missions available",
            'action' => "Actions",
        ],
        'create' => [
            'success' => "Mission created successfully!",
            'success-next' => "Mission created, continue...",
            'error' => "An error occurred. Please try again later.",
            'error-2' => "Please correct the errors below.",
        ],
        'delete' => [
            'success' => "Mission deleted successfully!",
            'confirm' => "Do you really want to delete this mission ?",
        ],
    ];
