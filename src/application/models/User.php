<?php

class Model_User implements Zend_Acl_Role_Interface, Zend_Acl_Resource_Interface
{

    /**
     * Identifiant Utilisateur
     *
     * @var integer
     */
    private $id;

    /**
     * Login Utilisateur
     *
     * @var string
     */
    private $login;

    /**
     * Password Utilisateur
     *
     * @var string
     */
    private $password;
   
    
    public function toArray()
    {
        return array(
            'id'       => $this->getId(),
            'login'    => $this->getLogin(),
            'password' => $this->getPassword()
        );
    }
    
    /**
    * @param integer $id
    * @return Model_User
    */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
     
    /**
    * @return integer
    */
    public function getId()
    {
        return $this->id;
    }
    
   /**
   * @param string $password
   * @return Model_User
   */
   public function setPassword($password)
   {
       $this->password = $password;
       return $this;
   }
    
   /**
   * @return string
   */
   public function getPassword()
   {
       return $this->password;
   }

    /**
     * Gets the Login Utilisateur.
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Sets the Login Utilisateur.
     *
     * @param string $login the login
     *
     * @return self
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Returns the string idenitifer of the resource
     * 
     * @return string
     */
    public function getResourceId()
    {
      return 'user';
    }

    /**
     * Returns the string identifier of the role
     * 
     * @return string
     */
    public function getRoleId()
    {
        if ($this->getId() === null) {
            return 'guest';
        } elseif ($this->getId() === 1) {
            return 'root';
        }

        return 'other';
    }
}