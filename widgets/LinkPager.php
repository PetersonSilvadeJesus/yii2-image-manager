<?php
namespace petersonsilvadejesus\imagemanager\widgets;

use kartik\select2\Select2;
use petersonsilvadejesus\imagemanager\assets\LinkPagerAsset;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\bootstrap4\ButtonDropdown;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\Dropdown;
use yii\bootstrap4\LinkPager as LinkPageBootstrap4;
use yii\helpers\Json;

class LinkPager extends LinkPageBootstrap4
{
    private $pageSizeList = [5, 10, 20, 30];

    public $pager_layout = '<div class="d-flex flex-row-reverse"><div class="ml-3 mr-3">{pageButtons}</div><div class="mt-1">{pageSizeList}</div></div>';
    public $sizeListHtmlOptions = ['class'=>'btn btn-sm btn-light'];

    protected $_page_param = 'page';
    protected $_page_size_param = 'per-page';

    public $maxButtonCount = 0;

    public function init()
    {
        parent::init();

        $this->_page_param = $this->pagination->pageParam;
        $this->_page_size_param = $this->pagination->pageSizeParam;

        $currentPageSize = $this->pagination->getPageSize();

        // Push current pageSize to $this->pageSizeList,
        // unique to avoid duplicating
        if ( !in_array($currentPageSize, $this->pageSizeList) ) {
            array_unshift($this->pageSizeList, $currentPageSize);
            $this->pageSizeList = array_unique($this->pageSizeList);

            // Sort
            sort($this->pageSizeList, SORT_NUMERIC);
        }
    }

    public function run()
    {
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }

        // Register our widget assets
        LinkPagerAsset::register($this->getView());

        // Params will be passed to javascript
        $jsOptions = [
            'pageParam' => $this->_page_param,
            'pageSizeParam' => $this->_page_size_param,

            // Current url
            'url' => $this->pagination->createUrl($this->pagination->getPage())
        ];

        // Register inline javascript codes
        // call init method, pass params
        $this->getView()->registerJs("demoPagerWidget.init(" . Json::encode($jsOptions) . ");");

        return preg_replace_callback("/{(\\w+)}/", function ($matches) {
            $sub_section_name = $matches[1];
            $sub_section_content = $this->renderSection($sub_section_name);

            return $sub_section_content === false ? $matches[1] : $sub_section_content;
        }, $this->pager_layout);
    }

    protected function renderSection($name)
    {
        switch ($name) {
            case 'pageButtons':
                // Call inherited renderPageButtons() method
                return $this->renderPageButtons();
            case 'pageSizeList':
                // Render sub section, page size dropDownList
                return $this->renderPageSizeList();
            default:
                return false;
        }
    }

    private function renderPageSizeList()
    {
        $html = "<div class='d-flex align-items-center'> <span class='mr-2 text-muted small'>" . Yii::t('imagemanager', 'Items per Page') . ":</span> ";
        $html .= Html::dropDownList($this->_page_size_param,
            $this->pagination->getPageSize(),
            array_combine($this->pageSizeList, $this->pageSizeList),
            $this->sizeListHtmlOptions
        );
        $html .= "</div>";
        return $html;
    }
}