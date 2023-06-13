<?php
declare(strict_types=1);

namespace Entity;

class Actor
{
    protected string $name;
    protected string $birthPlace;
    protected string $Birthdate;
    protected string $biography;
    protected string $deathDay;

    /**
     * @param string $name
     * @param string $birthPlace
     * @param string $Birthdate
     * @param string $biography
     * @param string $deathDay
     */
    public function __construct(string $name, string $birthPlace, string $Birthdate, string $biography, string $deathDay)
    {
        $this->name = $name;
        $this->birthPlace = $birthPlace;
        $this->Birthdate = $Birthdate;
        $this->biography = $biography;
        $this->deathDay = $deathDay;
    }

    /**
     * @return string
     */
    public function getDeathDay(): string
    {
        return $this->deathDay;
    }

    /**
     * @param string $deathDay
     */
    public function setDeathDay(string $deathDay): void
    {
        $this->deathDay = $deathDay;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getBirthPlace(): string
    {
        return $this->birthPlace;
    }

    /**
     * @param string $birthPlace
     */
    public function setBirthPlace(string $birthPlace): void
    {
        $this->birthPlace = $birthPlace;
    }

    /**
     * @return string
     */
    public function getBirthdate(): string
    {
        return $this->Birthdate;
    }

    /**
     * @param string $Birthdate
     */
    public function setBirthdate(string $Birthdate): void
    {
        $this->Birthdate = $Birthdate;
    }

    /**
     * @return string
     */
    public function getBiography(): string
    {
        return $this->biography;
    }

    /**
     * @param string $biography
     */
    public function setBiography(string $biography): void
    {
        $this->biography = $biography;
    }

}