<?php

namespace Curso\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Curso\MainBundle\Entity\Producto;
use Curso\MainBundle\Entity\Ciudad;
use Curso\MainBundle\Form\ProductoType;
use Symfony\Component\HttpFoundation\Request;

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
/*
  		$res = "Productos:<br>";
		
		foreach ($productos as $producto)
		{
			$res .= 'ID: ' . $producto->getId() . ' Nombre: ' . $producto->getNombre() . ' Precio: ' . $producto->getPrecio() . '<br>';
		}
		
		return new Response(
				$res
		);
*/
		$em = $this->getDoctrine()->getManager();
		$ciudades = $em->getRepository('CursoMainBundle:Ciudad')->findAll();
		
		return $this->render("CursoMainBundle:Default:productos.html.twig", array("productos" => $productos, "ciudades" => $ciudades));
	}
	
	public function getByIdAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		//$producto = $em->find('CursoMainBundle:Producto', $id);
		//$producto = $em->getRepository('CursoMainBundle:Producto')->find($id);
		$producto = $em->getRepository('CursoMainBundle:Producto')->findOneById($id);
		
		return new Response(
				'Producto: ' . $producto->getNombre(). ' con precio ' . $producto->getPrecio()
		);
	}
	
	public function getByNombreAction($nombre)
	{
		$repository = $this->getDoctrine()->getRepository('CursoMainBundle:Producto');
		//$producto = $repository->findByNombre($nombre);
		$producto = $repository->findOneByNombre($nombre);
		//$producto = $repository->findBy(array("nombre" => $nombre), 20, 0);
		
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
	
	public function nuevoProductoAction(Request $request)
	{
		// Forma avanzada y detallada de hacer el formulario.
		$producto = new Producto();
/*		$producto->setNombre("Probando formulario");
		$producto->setPrecio(300);
		$form = $this->createFormBuilder($producto)
		->add('nombre', 'text')
		->add('precio', 'integer')
		->add('guardar', 'submit')
		->getForm();
		return $this->render("CursoMainBundle:Default:formulario.html.twig", array(
				"form" => $form->createView()
		));		
*/
		$form = $this->createForm(new ProductoType(), $producto);
		
		$form->handleRequest($request);
	
/*		
		// Si usamos el validator.yml
		$validator = $this->get('validator');
		$errors = $validator->validate($producto);
	
		if (count($errors) > 0)
		{
			$errorString = (string) $errors;
			return new Response($errorString);
		}
*/
		
		// Nos devuelve si el formulario es valido o no.
		if ($form->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($producto);
			$em->flush();
			
			return $this->redirect($this->generateUrl('curso_main_allProd'));
		}
		
		return $this->render("CursoMainBundle:Default:formulario.html.twig", array(
				"form" => $form->createView()
		));		
		
		// Forma rápida de hacer el formulario
/*		
		$form = $this->createForm(new ProductoType());		
		return $this->render("CursoMainBundle:Default:formulario.html.twig", array(
			"form" => $form->createView()
		));
*/
	}
	
	public function editProductoAction(Request $request, $id)
	{
		// create a task and give it some dummy data for this example
		$em = $this->getDoctrine()->getManager();
		$producto = $em->getRepository('CursoMainBundle:Producto')->findOneById($id);
		
		$form = $this->createForm(new ProductoType(), $producto);
		
		$form->handleRequest($request);
		
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($producto);
			$em->flush();
		
			return $this->redirect($this->generateUrl('curso_main_allProd'));
		}
		
		return $this->render("CursoMainBundle:Default:formulario.html.twig", array(
				"form"=>$form->createView()
		));		
	}
}
