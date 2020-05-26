<?php

use craft\elements\Entry;
use craft\elements\GlobalSet;
use craft\helpers\UrlHelper;
use craft\helpers\ArrayHelper;
use craft\models\Section;

function transformBodyContent(Entry $entry){
    $bodyBlocks = [];
    $blocks = $entry->postContent->all();
    foreach ($blocks as $block) {
        switch ($block->type->handle) {
            case 'text':
                $bodyBlocks[] = [
                    'type' => 'text',
                    'text' => $block->text->getParsedContent(),
                ];
                break;
            case 'image':
                $image = $block->image->one();
                $bodyBlocks[] = [
                    'type' => 'image',
                    'image' => $image ? $image->getUrl() : null,
                ];
                break;
        }
    }
    return $bodyBlocks;
}


return [
    'endpoints' => [
        'site.json' => function() {
            return[
                'elementType' => 'craft\elements\GlobalSet',
                'criteria' => ['handle' => 'siteSettings'],
                'transformer' => function(GlobalSet $entry) {
                    $logo = $entry->logo->one();

                    $singleSections = ArrayHelper::where(\Craft::$app->sections->getAllSections(), 
                    'type', Section::TYPE_SINGLE);

                    $pages = Entry::find()
                        ->sectionId(ArrayHelper::getColumn($singleSections, 'id'))
                        ->all();

                    $pageInfos = [];

                    foreach ($pages as $page) {
                        $pageInfos[] = [
                            'title' => $page->title,
                            'url' => $page->url,
                            'jsonUrl' => UrlHelper::url("{$page->slug}.json")
                        ];
                    }
                    $pageInfos[] = [
                        'title' => 'portfolio',
                        'url' => UrlHelper::url("portfolio/"),
                        'jsonUrl' => UrlHelper::url("portfolio.json")
                    ];

                    $pageInfos[] = [
                        'title' => 'news', 
                        'url' => UrlHelper::url("news/"),
                        'jsonUrl' => UrlHelper::url("news.json")
                    ];

                    return [
                        'logo' => $logo ? $logo->getUrl(['height' => 100]) : null,
                        'footerText' => $entry->footerText,
                        'pages' => $pageInfos
                    ];
                },
                'one' => true,
                'meta' => [
                    'type' => 'sitedata'
                ],
            ];
        },
        '<_:home\.json|\.json>'  => function() {
            return[
                'elementType' => 'craft\elements\Entry',
                'criteria' => ['slug' => 'home'],
                'transformer' => function(Entry $entry) {
                    return [
                        'title' => $entry->title,
                        'date_published' => $entry->postDate->format(\DateTime::ATOM),
                        'date_modified' => $entry->dateUpdated->format(\DateTime::ATOM),
                        'content' => transformBodyContent($entry),
                    ];
                },
                'one' => true,
                'meta' => [
                    'type' => 'page'
                ],
            ];
        },
        'news.json'  => function() {
            return[
                'elementType' => 'craft\elements\Entry',
                'criteria' => [
                    'section' => 'news',
                    'orderBy' => 'postDate desc',
                ],
                'transformer' => function(Entry $entry) {
                    $featureImage = $entry->featureImage->one();

                    return [
                        'title' => $entry->title,
                        'date_published' => $entry->postDate->format(\DateTime::ATOM),
                        'date_modified' => $entry->dateUpdated->format(\DateTime::ATOM),
                        'url' => $entry->url,
                        'jsonUrl' => UrlHelper::url("news/{$entry->slug}.json"),
                        'excerpt' => $entry->excerpt,
                        'featureImage' => $featureImage? $featureImage->getUrl() : null,
                    ];
                },
                'elementsPerPage' => 8,
                'meta' => [
                    'type' => 'newslist'
                ],
            ];
        },
        'news/<slug:{slug}>.json'  => function($slug) {
            return[
                'elementType' => 'craft\elements\Entry',
                'criteria' => [
                    'section' => 'news',
                    'slug' => $slug
                ],
                'transformer' => function(Entry $entry) {
                    $featureImage = $entry->featureImage->one();

                    return [
                        'title' => $entry->title,
                        'date_published' => $entry->postDate->format(\DateTime::ATOM),
                        'date_modified' => $entry->dateUpdated->format(\DateTime::ATOM),
                        'content' => transformBodyContent($entry),
                        'excerpt' => $entry->excerpt,
                        'featureImage' => $featureImage? $featureImage->getUrl() : null,
                    ];
                },
                'one' => true,
                'meta' => [
                    'type' => 'newspost'
                ],
            ];
        },
    ]
];