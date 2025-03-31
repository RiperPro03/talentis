@extends('layouts.app')

@section('title', 'Mentions légales - Talentis')

@section('content')
    <section class="max-w-5xl mx-auto px-4 sm:px-6 py-10">
        <div class="card bg-base-100 shadow-xl p-6 sm:p-10 rounded-xl border">
            <h1 class="text-3xl font-bold text-center mb-6 text-primary">Mentions légales</h1>

            <div class="space-y-6 text-sm sm:text-base leading-relaxed text-gray-700">
                <!-- Éditeur -->
                <div>
                    <h2 class="text-xl font-semibold text-neutral mb-2">Éditeur du site</h2>
                    <p><span class="font-medium">Talentis</span><br>
                        16 Rue Magellan, Bâtiment Alpha<br>
                        31670 Labège, France<br>
                        Email : <a href="mailto:contact@talentis.fr" class="link link-primary">contact@talentis.fr</a>
                    </p>
                </div>

                <!-- Hébergement -->
                <div>
                    <h2 class="text-xl font-semibold text-neutral mb-2">Hébergement</h2>
                    <p>
                        <span class="font-medium">Laravel Cloud</span><br>
                        Site : <a href="https://cloud.laravel.com/" target="_blank" class="link link-primary">www.cloud.laravel.com</a>
                    </p>
                </div>

                <!-- Propriété intellectuelle -->
                <div>
                    <h2 class="text-xl font-semibold text-neutral mb-2">Propriété intellectuelle</h2>
                    <p>
                        Tous les contenus présents sur le site Talentis (textes, images, logos, etc.) sont protégés par le droit d’auteur. Toute reproduction est interdite sans autorisation préalable.
                    </p>
                </div>

                <!-- Responsabilité -->
                <div>
                    <h2 class="text-xl font-semibold text-neutral mb-2">Responsabilité</h2>
                    <p>
                        Talentis s’efforce de fournir des informations précises. Toutefois, nous ne garantissons pas l'exactitude, la complétude ou l’actualité des contenus. L'utilisateur reste responsable de l'utilisation des informations disponibles.
                    </p>
                </div>

                <!-- Données personnelles -->
                <div>
                    <h2 class="text-xl font-semibold text-neutral mb-2">Données personnelles</h2>
                    <p>
                        Les données personnelles collectées via Talentis sont utilisées uniquement dans le cadre de l’application. Conformément au RGPD, vous disposez d’un droit d’accès, de modification ou de suppression de vos données. Pour toute demande, contactez-nous à l’adresse :
                        <a href="mailto:contact@talentis.fr" class="link link-primary">contact@talentis.fr</a>.
                    </p>
                </div>

                <!-- Cookies -->
                <div>
                    <h2 class="text-xl font-semibold text-neutral mb-2">Cookies</h2>
                    <p>
                        Le site Talentis utilise des cookies uniquement à des fins techniques et de bon fonctionnement de l'application (ex. : maintien de session, préférences utilisateur). Aucun cookie publicitaire ou de suivi n'est utilisé.
                    </p>
                    <p class="mt-2">
                        Vous pouvez configurer votre navigateur pour refuser tout ou partie des cookies. Toutefois, certaines fonctionnalités du site pourraient ne plus fonctionner correctement sans cookies.
                    </p>
                </div>

                <!-- Crédits -->
                <div>
                    <h2 class="text-xl font-semibold text-neutral mb-2">Crédits</h2>
                    <p>
                        Talentis a été créé par une équipe d'étudiants ingénieurs en informatique du <span class="font-semibold">CESI</span> :
                    </p>
                    <ul class="list-disc list-inside ml-4 mt-2 text-gray-600">
                        <li>Christopher Asin</li>
                        <li>Enzo Casse</li>
                        <li>Quentin Chabres</li>
                        <li>Dagmawi Desta</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
