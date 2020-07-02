<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
/**
 * Description of MyGump
 *
 * @author myaskpc
 */

/**
 * GUMP 확장
 */
class MyGump extends GUMP
{

    /**
     * 한글,영어,숫자 - _ comma
     * @param type $field
     * @param type $input
     * @param type $param
     * @return type
     */
    public function validate_alpha_dash_comma($field, $input, $param = NULL)
    {
        if (!isset($input[$field]) || empty($input[$field])) {
            return;
        }

        if (!preg_match('/^([,가-힣a-zA-Z0-9_-])+$/i', $input[$field]) !== false) {
            return array(
                'field' => $field,
                'value' => $input[$field],
                'rule' => __FUNCTION__,
                'param' => $param,
            );
        }
    }

    /**
     * 검사안함
     * @param type $field
     * @param type $input
     * @param type $param
     * @return type
     */
    public function validate_notvali($field, $input, $param = NULL)
    {
        if (!isset($input[$field]) || empty($input[$field])) {
            return;
        }

        if (!preg_match('/^(.)+$/i', $input[$field]) !== false) {
            return array(
                'field' => $field,
                'value' => $input[$field],
                'rule' => __FUNCTION__,
                'param' => $param,
            );
        }
    }
}
