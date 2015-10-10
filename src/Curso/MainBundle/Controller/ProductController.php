<?php

namespace Curso\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Curso\MainBundle\Entity\Producto;

class ProductController extends Controller
{
	public function addOneAction($nombre, $precio)
	{
		$producto = new Producto();
		$producto->setNombre($nombre);
		$producto->setPrecio($precio);

		// Con esto recuperamos el manager de Symfony
		$em = $this->getDoctrine()->getManager();
		$em->persist($producto);	// Pasamos la entidad a tratar por Doctrine
		$em->flush();	// Con esto lo almacenamos en la base de datos realmente.

		return new Response(
				'Id del nuevo producto: ' . $producto->getId() . '; el producto se ha creado OK'
		);
	}

	public function getAllAction()
	{
		$em = $this->getDoctrine()->getManager();
		$productos = $em->getRepository('CursoMainBundle:Producto')->findAll();
		$res = "Productos:<br>";
		
		foreach ($productos as $producto)
		{
			$res .= 'ID: ' . $producto->getId() . ' Nombre: ' . $producto->getNombre() . ' Precio: ' . $producto->getPrecio() . '<br>';
		}
		
		return new Response(
				$res
		);
	}
	
	public function getByIdAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		//$producto = $em->find('CursoMainBundle:Producto', $id);
		//$producto = $em->getRepository('CursoMainBundle:Producto')->find($id);
		$producto = $em->getRepository('CursoMainBundle:Producto')->findOneBy($id);
		
		return new Response(
				'Producto: ' . $producto->getNombre(). ' con precio ' . $producto->getPrecio()
		);
	}
	
	public function getByNombreAction($nombre)
	{
		$repository = $this->getDoctrine()->getRepository('CursoMainBundle:Producto');
		//$producto = $repository->findByNombre($nombre);
		$producto = $repository->findOneByNombre($nombre);
		//$producto =$repository->findBy(array("nombre" => $nombre), 20, 0);
		
		return new Response(
				'Producto: ' . $producto->getNombre(). ' con precio ' . $producto->getPrecio()
		);
	}
	
	public function updateAction($id, $nombre, $precio)
	{
		$em = $this->getDoctrine()->getManager();
		$producto = $em->getRepository('CursoMainBundle:Producto')->find($id);
		
		if ( ! $producto)
		{
			throw $this->createNotFoundException(
					'No se ha encontrado el producto con la id ' . $id
			);
			
		}
		
		$producto->setNombre($nombre);
		$producto->setPrecio($precio);
		$em->flush();
		return new Response(
				'Producto: ' . $producto->getNombre() . ' con precio ' . $producto->getPrecio() . ' modificado'
		);
	}
	
	public function deleteAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$producto = $em->getRepository('CursoMainBundle:Producto')->find($id);
		
		if ( ! $producto)
		{
			throw $this->createNotFoundException(
					'No se ha encontrado el producto con la id ' . $id
			);
			
		}
		
		$em->remove($producto);
		$em->flush();
		return new Response(
				'Producto eliminado'
		);
	}
}
