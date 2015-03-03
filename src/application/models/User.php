<?php

class Model_User
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
}