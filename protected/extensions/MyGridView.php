<?php

/**
 * 自定义多表头
 * @author Elf-mousE <ni.jun@sh.adways.net>
 * @since 2013.12.13 (last updated: 2014.05.07)
 *
 * @usage
 * // array中的key为表字段或翻译文件key字段
 * // array中的value为翻译
 * $this->widget('ext.MyGridView', array(
 *     ...
 *     //'rowspan' => 2,
 *     'thead' => array(
 *         array(
 *             'id',
 *             'name' => 'Username',
 *             'time' => array('name'=>'Show Time', 'colspan'=>2),
 *         ),
 *         array(
 *             'created' => 'Create Time',
 *             'updated',
 *         )
 *     ),
 *     ...
 * ));
 */
Yii::import('zii.widgets.grid.CGridView');

class MyGridView extends CGridView {

    private $head_index = 0;
    public $rowspan = 2;
    public $thead;

    public function init() {
        $this->cssFile = Yii::app()->params['baseImageUrl'] . '/css/gridview/styles.css';
        parent::init();
    }

    private function outputHeaderName($key, $val) {
        if (!$val) {
            $i = $this->head_index;
            if (isset($this->columns[$i]->header)) {
                echo $this->columns[$i]->header;
            } else {
                $dataProvider = $this->dataProvider;
                if ($dataProvider instanceof CActiveDataProvider)
                    echo ($dataProvider->model->getAttributeLabel($key));
                else
                    echo ($key);
            }
            ++$this->head_index;
        } else {
            echo $val;
        }
    }

    private function outputHeaderRow($row) {
        echo "<tr>\n";
        foreach ($row as $key => $val) {
            if (is_string($val)) {
                echo CHtml::openTag('th', array('rowspan' => $this->rowspan));
                if (is_string($key)) {
                    $this->outputHeaderName($key, $val);
                } else {
                    $this->outputHeaderName($val, false);
                }
            } else {
                if (isset($val['name'])) {
                    $htmlOptions = $val;
                    unset($htmlOptions['name']);
                    echo CHtml::openTag('th', $htmlOptions);
                    $this->outputHeaderName($key, $val['name']);
                } else {
                    $val['colspan'] = 1;
                    $htmlOptions = array_merge($val, array('rowspan' => $this->rowspan));
                    echo CHtml::openTag('th', $htmlOptions);
                    $this->outputHeaderName($key, false);
                }
            }
            echo "</th>";
        }
        echo "</tr>\n";
    }

    /**
     * Renders the table header.
     */
    public function renderTableHeader() {
        if (!$this->hideHeader) {
            echo "<thead>\n";

            if ($this->filterPosition === self::FILTER_POS_HEADER)
                $this->renderFilter();

            if ($this->thead) {
                $first_row = $this->thead[0];
                $this->outputHeaderRow($first_row);
                if ($this->rowspan > 1) {
                    for ($i = 1; $i < $this->rowspan; $i++) {
                        if (isset($this->thead[$i])) {
                            $rowData = $this->thead[$i];
                            echo "<tr>\n";
                            foreach ($rowData as $key => $val) {
                                if (is_string($val)) {
                                    echo CHtml::openTag('th');
                                    if (is_string($key)) {
                                        $this->outputHeaderName($key, $val);
                                    } else {
                                        $this->outputHeaderName($val, false);
                                    }
                                } else {
                                    if (isset($val['name'])) {
                                        $htmlOptions = $val;
                                        unset($htmlOptions['name']);
                                        echo CHtml::openTag('th', $htmlOptions);
                                        $this->outputHeaderName($key, $val['name']);
                                    } else {
                                        $val['colspan'] = isset($val['colspan']) ? $val['colspan'] : 1;
                                        $htmlOptions = $val;
                                        echo CHtml::openTag('th', $htmlOptions);
                                        $this->outputHeaderName($key, false);
                                    }
                                }
                                echo "</th>";
                            }
                            echo "</tr>\n";
                        }
                    }
                }
            } else {
                echo "<tr>\n";
                foreach ($this->columns as $column)
                    $column->renderHeaderCell();
                echo "</tr>\n";
            }

            if ($this->filterPosition === self::FILTER_POS_BODY)
                $this->renderFilter();

            echo "</thead>\n";
        }
        else if ($this->filter !== null && ($this->filterPosition === self::FILTER_POS_HEADER || $this->filterPosition === self::FILTER_POS_BODY)) {
            echo "<thead>\n";
            $this->renderFilter();
            echo "</thead>\n";
        }
    }

}