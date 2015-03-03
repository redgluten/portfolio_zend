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
            Model_DbTable_User::COL_ID . ' = ?' => $user->getUserId()
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
        $user->setUserId($data[Model_DbTable_User::COL_ID])
            ->setUserLogin($data[Model_DbTable_User::COL_LOGIN])
            ->setUserPassword($data[Model_DbTable_User::COL_PASSWORD]);
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
            Model_DbTable_User::COL_ID => $user->getUserId(),
            Model_DbTable_User::COL_LOGIN => $user->getUserLogin(),
            Model_DbTable_User::COL_PASSWORD => $user->getUserPassword()
        );
    }
}