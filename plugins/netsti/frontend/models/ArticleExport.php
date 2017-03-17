<?php namespace NetSTI\Frontend\Models;

use Backend\Models\ExportModel;
use ApplicationException;

/**
 * Post Export Model
 */
class ArticleExport extends ExportModel
{
    public $table = 'netsti_frontend_articles';

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'post_user' => [
            'Backend\Models\User',
            'key' => 'user_id'
        ]
    ];

    public $belongsToMany = [
        'post_categories' => [
            'NetSTI\Frontend\Models\Category',
            'table' => 'netsti_frontend_newscategories',
            'key' => 'post_id',
            'otherKey' => 'category_id'
        ]
    ];

    protected $appends = [
        'author_email',
        'categories'
    ];

    public function exportData($columns, $sessionKey = null)
    {
        $result = self::make()
            ->with([
                'post_user',
                'post_categories'
            ])
            ->get()
            ->toArray()
        ;

        return $result;
    }

    public function getAuthorEmailAttribute()
    {
        if (!$this->post_user) return '';
        return $this->post_user->email;
    }

    public function getCategoriesAttribute()
    {
        if (!$this->post_categories) return '';
        return $this->encodeArrayValue($this->post_categories->lists('name'));
    }
}