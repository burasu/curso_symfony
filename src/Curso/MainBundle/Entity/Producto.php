<?php
namespace Curso\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Producto
 * 
 * @ORM\Table()
 * @ORM\Entity
 */
class Producto
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $nombre;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $precio;	
	
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getNombre()
	{
		return $this->nombre;
	}
	
	public function setNombre($nombre)
	{
		$this->nombre = $nombre;
	}
	
	public function getPrecio()
	{
		return $this->precio;
	}
	
	public function setPrecio($precio)
	{
		$this->precio = $precio;
	}
}