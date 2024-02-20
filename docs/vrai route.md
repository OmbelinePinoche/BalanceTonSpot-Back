

 /**
     * Create a user with a form in the backoffice
     * 
     * @return Response
     */
   
 #[Route('/new', name: 'add_user')]
    public function create(Request $request, EntityManagerInterface  $entityManager): Response
    {
        // Create an instance for the entity user
        $user = new user();
        // Create a form
        $form = $this->createForm(UserType::class, $user); 

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);

        // Checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Hachez le mot de passe avant de l'enregistrer dans la base de données
            $hashedPassword = $this->passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);
            // Persistez l'utilisateur dans la base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // We will display a flash message which will allow us to display whether or not the user has been created.
            $this->addFlash(
                'succès',
                'L\'utilisateur '.$user->getEmail().'a bien été créé !'
            );
            
            // Return the users in the view
            return $this->redirectToRoute('list_user');
        }
        return $this->render('back/user/create.html.twig', [
            'form' => $form,
        ]);
    }