<?php

class Model_Mapper_User
{

    private $userTable;

    /**
     * Récupération de tout les éléments répondant à where
     * 
     * @param string $where            
     * @param string $order            
     * @param string $count            
     * @param string $offset            
     * @return boolean|array
     */
    public function fetchAll($where = null, $order = null, $count = null, $offset = null)
    {
        $result = $this->getUserTable()->fetchAll($where, $order, $count, $offset);
        if (0 === $result->count()) {
            return false;
        }
        $users = array();
        foreach ($result as $row) {
            $users[] = $this->rowToObject($row);
        }
        return $users;
    }

    /**
     * Récupération d'un élement avec ID
     * @param integer $userId
     * @return boolean
     */
    public function find($userId)
    {
        $result = $this->getUserTable()->find($userId);
        if (0 === $result->count()) {
            return false;
        }
        return $this->rowToObject($result[0]);
    }
    
    /**
     * Insertion d'un Model_User en BDD
     * @param Model_User $user
     * @return mixed
     */
    public function insert(Model_User $user)
    {
        $data = $this->objectToRow($user);
        return $this->getUserTable()->insert($data);
    }

    /**
     * Mise à jour d'un Model_User en BDD
     * @param Model_User $user
     */
    public function update(Model_User $user)
    {
        $data  = $this->objectToRow($user);
        $where = array(
            Model_DbTable_User::COL_ID . ' = ?' => $user->getId()
        );
        return $this->getUserTable()->update($data, $where);
    }

    /**
     * Retourne l'objet DbTable de User
     * @return Model_DbTable_User
     */
    private function getUserTable()
    {
        if (null === $this->userTable) {
            $this->userTable = new Model_DbTable_User();
        }
        return $this->userTable;
    }
    
    /**
     * Converti un tableau de donnée en Model_User
     * @param array $data
     * @return Model_User
     */
    private function rowToObject($data)
    {
        $user = new Model_User();
        $user->setId($data[Model_DbTable_User::COL_ID])
            ->setLinkedinID($data[Model_DbTable_User::COL_LINKEDIN_ID])
            ->setViadeoId($data[Model_DbTable_User::COL_VIADEO_ID])
            ->setLogin($data[Model_DbTable_User::COL_LOGIN])
            ->setEmail($data[Model_DbTable_User::COL_EMAIL])
            ->setPassword($data[Model_DbTable_User::COL_PASSWORD])
            ->setCreated();
        return $user;
    }

    /**
     * Converti Model_User en un tableau de donnée
     * @param Model_User $user
     * @return array
     */
    private function objectToRow(Model_User $user)
    {
        return array(
            Model_DbTable_User::COL_ID          => $user->getId(),
            Model_DbTable_User::COL_LINKEDIN_ID => $user->getLinkedinId(),
            Model_DbTable_User::COL_VIADEO_ID   => $user->getViadeoId(),
            Model_DbTable_User::COL_LOGIN       => $user->getLogin(),
            Model_DbTable_User::COL_EMAIL       => $user->getEmail(),
            Model_DbTable_User::COL_PASSWORD    => $user->getPassword(),
            Model_DbTable_User::COL_CREATED     => $user->getCreated()->toString(Zend_Date::DATETIME)
        );
    }
}