<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    #[Route("/lucky/number/twig", name: "lucky_number")]
    public function number(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'number' => $number
        ];

        return $this->render('lucky_number.html.twig', $data);
    }

    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }
    #[Route("/lucky", name: "lucky")]
    public function lucky(): Response
    {
        $albums = [
            [
                'title' => 'Taylor Swift / Debut',
                'cover' => 'img/ts-debut.webp',
                'spotify' => 'https://open.spotify.com/album/5eyZZoQEFQWRHkV2xgAeBw?si=DRFujDCUR6-vOsCL3DXj-A',
            ],
            [
                'title' => "Fearless - Taylor's Version",
                'cover' => 'img/ts-fearlesstv.webp',
                'spotify' => 'https://open.spotify.com/album/4hDok0OAJd57SGIT8xuWJH?si=TBKOFa3VRMeB02h2L0vgsw',
            ],
            [
                'title' => "Red - Taylor's Version",
                'cover' => 'img/ts-redtv.webp',
                'spotify' => 'https://open.spotify.com/album/6kZ42qRrzov54LcAk4onW9?si=PYABBrhTRnKwbs-qMy1GvA',
            ],
            [
                'title' => "1989 - Taylor's version",
                'cover' => 'img/ts-1989tv.webp',
                'spotify' => 'https://open.spotify.com/album/1o59UpKw81iHR0HPiSkJR0?si=0929OPuhQ6GNYHekpHebAQ',
            ],
            [
                'title' => "Speak Now - Taylor's Version",
                'cover' => 'img/ts-speaknowtv.webp',
                'spotify' => 'https://open.spotify.com/album/5AEDGbliTTfjOB8TSm1sxt?si=1IuLk2LyQt6whR6dyhUiBw',
            ],
            [
                'title' => 'Reputation',
                'cover' => 'img/ts-rep.webp',
                'spotify' => 'https://open.spotify.com/album/6DEjYFkNZh67HP7R9PSZvv?si=ZuOXdN7FRXmJ9ABrq_1usg',
            ],
            [
                'title' => 'Lover',
                'cover' => 'img/ts-lover.webp',
                'spotify' => 'https://open.spotify.com/album/1NAmidJlEaVgA3MpcPFYGq?si=AAu1cxdSTn61RFLa4zKSGg',
            ],
            [
                'title' => 'folklore',
                'cover' => 'img/ts-folklore.webp',
                'spotify' => 'https://open.spotify.com/album/1pzvBxYgT6OVwJLtHkrdQK?si=nyKrSPWuTlqao0aifeYRSg',
            ],
            [
                'title' => 'evermore',
                'cover' => 'img/ts-evermore.webp',
                'spotify' => 'https://open.spotify.com/album/6AORtDjduMM3bupSWzbTSG?si=N89SfD6dQ4O6LG9Zj8oa2Q',
            ],
            [
                'title' => 'Midnights',
                'cover' => 'img/ts-midnights.webp',
                'spotify' => 'https://open.spotify.com/album/1fnJ7k0bllNfL1kVdNVW1A?si=hpDVe9I1RgyY_rs0UrVMhg',
            ],
            [
                'title' => 'The Tortured Poets Department',
                'cover' => 'img/ts-ttpd.webp',
                'spotify' => 'https://open.spotify.com/album/5H7ixXZfsNMGbIE5OBSpcb?si=FDlHvvBIQn-6NGhx1wkcMQ',
            ],
        ];

        $randomAlbum = $albums[array_rand($albums)];

        return $this->render('lucky.html.twig', [ 'album' => $randomAlbum]);
    }
}
