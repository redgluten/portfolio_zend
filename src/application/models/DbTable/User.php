<?php 
class Model_DbTable_User extends Zend_Db_Table_Abstract
{
    CONST TABLE_NAME      = 'user';
    CONST COL_ID          = 'id';
    CONST COL_LINKEDIN_ID = 'id';
    CONST COL_VIADEO_ID   = 'id';
    CONST COL_LOGIN       = 'login';
    CONST COL_PASSWORD    = 'password';
    CONST COL_EMAIL       = 'email';
    CONST COL_CREATED     = 'created';
    
    protected $_name    = self::TABLE_NAME;
    protected $_primary = self::COL_ID;
}