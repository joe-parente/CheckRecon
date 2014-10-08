<?php

/*
 * Copyright (C) 2014 Joe
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace AuthMod\Entity; 

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Zend\Form\Annotation; 

// setters and getters - Zend\Stdlib\Hydrator\ClassMethods, for public properties - Zend\Stdlib\Hydrator\ObjectProperty, array
// Zend\Stdlib\Hydrator\ArraySerializable
// Follows the definition of ArrayObject.
// Objects must implement either the exchangeArray() or populate() methods to support hydration,
// and the getArrayCopy() method to support extraction.
// https://bitbucket.org/todor_velichkov/homeworkuniversity/src/935b37b87e3f211a72ee571142571089dffbf82d/module/University/src/University/Form/StudentForm.php?at=master
// read here http://framework.zend.com/manual/2.1/en/modules/zend.form.quick-start.html
/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AuthMod\Entity\Repository\UserRepository")
 * @Annotation\Name("user")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */

class User {

    /**
     * @var string
     *
     * @ORM\Column(name="usr_name", type="string", length=100, nullable=false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":30}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[a-zA-Z][a-zA-Z0-9_-]{0,24}$/"}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Username:"})
     */
    private $usrName;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_password", type="string", length=100, nullable=false)
     * @Annotation\Attributes({"type":"password"})
     * @Annotation\Options({"label":"Password:"})
     */
    private $usrPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_email", type="string", length=60, nullable=false)
     * @Annotation\Type("Zend\Form\Element\Email")
     * @Annotation\Options({"label":"Your email address:"})
     */
    private $usrEmail;

    /**
     * @var integer
     *
     * @ORM\Column(name="usrl_id", type="integer", nullable=true)
     * @ORM\OneToMany(targetEntity="user_roles")
     * @ORM\JoinColumn(name="usrl_id", referencedColumnName="usrl_id")
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Options({
     * "label":"User Role:",
     * "value_options":{ "0":"Select Role", "1":"Public", "2": "Member"}})
     */
    private $usrlId;

    /**
     * @var integer
     *
     * @ORM\Column(name="lng_id", type="integer", nullable=true)
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Language Id:"})
     */
    private $lngId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="usr_active", type="boolean", nullable=false)
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({
     * "label":"User Active:",
     * "value_options":{"1":"Yes", "0":"No"}})
     */
    private $usrActive;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_question", type="string", length=100, nullable=true)
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"User Question:"})
     */
    private $usrQuestion;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_answer", type="string", length=100, nullable=true)
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"User Answer:"})
     */
    private $usrAnswer;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_picture", type="string", length=255, nullable=true)
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"User Picture:"})
     */
    private $usrPicture;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_password_salt", type="string", length=100, nullable=true)
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Password Salt:"})
     */
    private $usrPasswordSalt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="usr_registration_date", type="datetime", nullable=true)
     * @Annotation\Attributes({"type":"datetime","min":"2010-01-01T00:00:00Z","max":"2020-01-01T00:00:00Z","step":"1"})
     * @Annotation\Options({"label":"Registration Date:", "format":"Y-m-d\TH:iP"})
     */
    private $usrRegistrationDate; // = '2013-07-30 00:00:00'; // new \DateTime() - coses synatx error
    /**
     * @var string
     *
     * @ORM\Column(name="usr_registration_token", type="string", length=100, nullable=true)
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Registration Token:"})
     */
    private $usrRegistrationToken;

    /**
     * @var boolean
     *
     * @ORM\Column(name="usr_email_confirmed", type="boolean", nullable=false)
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({
     * "label":"User confirmed email:",
     * "value_options":{"1":"Yes", "0":"No"}})
     */
    private $usrEmailConfirmed;

    /**
     * @var integer
     *
     * @ORM\Column(name="usr_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Annotation\Exclude()
     */
    private $usrId;

    public function __construct() {
        $this->usrRegistrationDate = new \DateTime();
    }

    /**
     * Set usrName
     *
     * @param string $usrName
     * @return Users
     */
    public function setUsrName($usrName) {
        $this->usrName = $usrName;
        return $this;
    }

    /**
     * Get usrName
     *
     * @return string
     */
    public function getUsrName() {
        return $this->usrName;
    }

    /**
     * Set usrPassword
     *
     * @param string $usrPassword
     * @return Users
     */
    public function setUsrPassword($usrPassword) {
        $this->usrPassword = $usrPassword;
        return $this;
    }

    /**
     * Get usrPassword
     *
     * @return string
     */
    public function getUsrPassword() {
        return $this->usrPassword;
    }

    /**
     * Set usrEmail
     *
     * @param string $usrEmail
     * @return Users
     */
    public function setUsrEmail($usrEmail) {
        $this->usrEmail = $usrEmail;
        return $this;
    }

    /**
     * Get usrEmail
     *
     * @return string
     */
    public function getUsrEmail() {
        return $this->usrEmail;
    }

    /**
     * Set usrlId
     *
     * @param integer $usrlId
     * @return Users
     */
    public function setUsrlId($usrlId) {
        $this->usrlId = $usrlId;
        return $this;
    }

    /**
     * Get usrlId
     *
     * @return integer
     */
    public function getUsrlId() {
        return $this->usrlId;
    }

    /**
     * Set lngId
     *
     * @param integer $lngId
     * @return Users
     */
    public function setLngId($lngId) {
        $this->lngId = $lngId;
        return $this;
    }

    /**
     * Get lngId
     *
     * @return integer
     */
    public function getLngId() {
        return $this->lngId;
    }

    /**
     * Set usrActive
     *
     * @param boolean $usrActive
     * @return Users
     */
    public function setUsrActive($usrActive) {
        $this->usrActive = $usrActive;
        return $this;
    }

    /**
     * Get usrActive
     *
     * @return boolean
     */
    public function getUsrActive() {
        return $this->usrActive;
    }

    /**
     * Set usrQuestion
     *
     * @param string $usrQuestion
     * @return Users
     */
    public function setUsrQuestion($usrQuestion) {
        $this->usrQuestion = $usrQuestion;
        return $this;
    }

    /**
     * Get usrQuestion
     *
     * @return string
     */
    public function getUsrQuestion() {
        return $this->usrQuestion;
    }

    /**
     * Set usrAnswer
     *
     * @param string $usrAnswer
     * @return Users
     */
    public function setUsrAnswer($usrAnswer) {
        $this->usrAnswer = $usrAnswer;
        return $this;
    }

    /**
     * Get usrAnswer
     *
     * @return string
     */
    public function getUsrAnswer() {
        return $this->usrAnswer;
    }

    /**
     * Set usrPicture
     *
     * @param string $usrPicture
     * @return Users
     */
    public function setUsrPicture($usrPicture) {
        $this->usrPicture = $usrPicture;
        return $this;
    }

    /**
     * Get usrPicture
     *
     * @return string
     */
    public function getUsrPicture() {
        return $this->usrPicture;
    }

    /**
     * Set usrPasswordSalt
     *
     * @param string $usrPasswordSalt
     * @return Users
     */
    public function setUsrPasswordSalt($usrPasswordSalt) {
        $this->usrPasswordSalt = $usrPasswordSalt;
        return $this;
    }

    /**
     * Get usrPasswordSalt
     *
     * @return string
     */
    public function getUsrPasswordSalt() {
        return $this->usrPasswordSalt;
    }

    /**
     * Set usrRegistrationDate
     *
     * @param string $usrRegistrationDate
     * @return Users
     */
    public function setUsrRegistrationDate($usrRegistrationDate) {
        $this->usrRegistrationDate = $usrRegistrationDate;
        return $this;
    }

    /**
     * Get usrRegistrationDate
     *
     * @return string
     */
    public function getUsrRegistrationDate() {
        return $this->usrRegistrationDate;
    }

    /**
     * Set usrRegistrationToken
     *
     * @param string $usrRegistrationToken
     * @return Users
     */
    public function setUsrRegistrationToken($usrRegistrationToken) {
        $this->usrRegistrationToken = $usrRegistrationToken;
        return $this;
    }

    /**
     * Get usrRegistrationToken
     *
     * @return string
     */
    public function getUsrRegistrationToken() {
        return $this->usrRegistrationToken;
    }

    /**
     * Set usrEmailConfirmed
     *
     * @param string $usrEmailConfirmed
     * @return Users
     */
    public function setUsrEmailConfirmed($usrEmailConfirmed) {
        $this->usrEmailConfirmed = $usrEmailConfirmed;
        return $this;
    }

    /**
     * Get usrEmailConfirmed
     *
     * @return string
     */
    public function getUsrEmailConfirmed() {
        return $this->usrEmailConfirmed;
    }

    /**
     * Get usrId
     *
     * @return integer
     */
    public function getUsrId() {
        return $this->usrId;
    }

}
