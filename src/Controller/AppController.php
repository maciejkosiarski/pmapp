<?php

namespace App\Controller;

use App\Entity\Conversion;
use App\Exception\ConvertException;
use App\Form\ConversionType;
use App\Repository\ConversionRepository;
use App\Service\ConversionService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Exception\GuzzleException;

/**
 * @Route("/")
 */
class AppController extends Controller
{
	/**
	 * @Route("/", name="conversion_index", methods="GET")
	 * @param ConversionRepository $repository
	 * @return Response
	 */
	public function index(ConversionRepository $repository): Response
	{
		return $this->render('conversion/index.html.twig', ['conversions' => $repository->findAll()]);
	}

	/**
	 * @Route("/new", name="conversion_new", methods="GET|POST")
	 * @param Request           $request
	 * @param ConversionService $conversionService
	 * @return Response
	 * @throws GuzzleException
	 */
	public function new(Request $request, ConversionService $conversionService): Response
	{
		$form = $this->createForm(ConversionType::class, (new Conversion()));

		$form->handleRequest($request);

		try {
			if($form->isSubmitted() && $form->isValid()) {
				$conversion = $conversionService->convert($request->get('conversion'));

				$this->addFlash('success', $conversion->successMessage());
			}
		} catch (ConvertException $e) {
			$this->addFlash('warning', $e->getMessage());
		} catch (\Exception $e) {
			$this->addFlash('warning', 'We have problems, please try again later');
		} finally {
			return $this->render('conversion/new.html.twig', ['form' => $form->createView()]);
		}
	}

	/**
	 * @Route("/{id}", name="conversion_delete", methods="DELETE")
	 * @param Request    $request
	 * @param Conversion $conversion
	 * @return RedirectResponse
	 */
	public function delete(Request $request, Conversion $conversion): Response
	{
		if ($this->isCsrfTokenValid('delete' . $conversion->getId(), $request->request->get('_token'))) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($conversion);
			$em->flush();
		}

		$this->addFlash('success', 'Conversion successfully removed.');

		return $this->redirectToRoute('conversion_index');
	}
}
