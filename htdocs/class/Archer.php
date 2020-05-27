<?php



class Archer extends Personnage
{
    protected $type;

    public function type()
  {
    return $this->type;
  }

  public function setType($type)
  {

    $this->type = $type;
  }
}