<?php

declare(strict_types=1);

namespace Tests\Doubles\Stubs\NYTimesBooks;

class GetBestSellerHistoryResponse
{
    public const EMPTY_RESPONSE = [
        'status' => 'OK',
        'copyright' => 'Copyright (c) 2025 The New York Times Company.  All Rights Reserved.',
        'num_results' => 0,
        'results' => [],
    ];
    
    public const SINGLE_RESULT_RESPONSE = [
        'status' => 'OK',
        'copyright' => 'Copyright (c) 2025 The New York Times Company.  All Rights Reserved.',
        'num_results' => 1,
        'results' => [
            [
                'title' => '1,000 PLACES TO SEE BEFORE YOU DIE',
                'description' => 'A guide for traveling the world; second edition updated with new entries.',
                'contributor' => 'by Patricia Schultz',
                'author' => 'Patricia Schultz',
                'contributor_note' => '',
                'price' => '0.00',
                'age_group' => '',
                'publisher' => 'Workman',
                'isbns' => [
                    [
                        'isbn10' => '0761156860',
                        'isbn13' => '9780761156864',
                    ],
                    [
                        'isbn10' => '0761104844',
                        'isbn13' => '9780761104841',
                    ],
                ],
                'ranks_history' => [
                    [
                        'primary_isbn10' => '0761156860',
                        'primary_isbn13' => '9780761156864',
                        'rank' => 10,
                        'list_name' => 'Travel',
                        'display_name' => 'Travel',
                        'published_date' => '2015-04-12',
                        'bestsellers_date' => '2015-03-28',
                        'weeks_on_list' => 0,
                        'rank_last_week' => 0,
                        'asterisk' => 0,
                        'dagger' => 0,
                    ],
                ],
                'reviews' => [
                    [
                        'book_review_link' => '',
                        'first_chapter_link' => '',
                        'sunday_review_link' => '',
                        'article_chapter_link' => '',
                    ],
                ],
            ],
        ],
    ];
    
    public const MULTIPLE_RESULTS_RESPONSE = [
        'status' => 'OK',
        'copyright' => 'Copyright (c) 2025 The New York Times Company.  All Rights Reserved.',
        'num_results' => 5,
        'results' => [
            [
                'title' => '100 BULLETS, VOL. 13',
                'description' => 'No spoilers! The noir series, about vengeance and violence, reaches its conclusion.',
                'contributor' => 'by Brian Azzarello and Eduardo Risso',
                'author' => 'Brian Azzarello and Eduardo Risso',
                'contributor_note' => '',
                'price' => '19.99',
                'age_group' => '',
                'publisher' => 'Vertigo',
                'isbns' => [],
                'ranks_history' => [
                    [
                        'primary_isbn10' => '1401222870',
                        'primary_isbn13' => '9781401222871',
                        'rank' => 2,
                        'list_name' => 'Paperback Graphic Books',
                        'display_name' => 'Paperback Graphic Books',
                        'published_date' => '2009-08-02',
                        'bestsellers_date' => '2009-07-18',
                        'weeks_on_list' => 2,
                        'rank_last_week' => 10,
                        'asterisk' => 0,
                        'dagger' => 0,
                    ],
                    [
                        'primary_isbn10' => '1401222870',
                        'primary_isbn13' => '9781401222871',
                        'rank' => 10,
                        'list_name' => 'Paperback Graphic Books',
                        'display_name' => 'Paperback Graphic Books',
                        'published_date' => '2009-07-26',
                        'bestsellers_date' => '2009-07-11',
                        'weeks_on_list' => 1,
                        'rank_last_week' => 0,
                        'asterisk' => 0,
                        'dagger' => 0,
                    ],
                ],
                'reviews' => [
                    [
                        'book_review_link' => '',
                        'first_chapter_link' => '',
                        'sunday_review_link' => '',
                        'article_chapter_link' => '',
                    ],
                ],
            ],
            [
                'title' => '100 BULLETS: BOOK ONE',
                'description' => 'This deluxe edition of the noir series, about a man named Graves who gives wronged people an untraceable gun to exact revenge, collects issues 1 through 19.',
                'contributor' => 'by Brian Azzarello and Eduardo Risso',
                'author' => 'Brian Azzarello and Eduardo Risso',
                'contributor_note' => '',
                'price' => '49.99',
                'age_group' => '',
                'publisher' => 'DC Comics',
                'isbns' => [
                    [
                        'isbn10' => '1401232019',
                        'isbn13' => '9781401232016',
                    ],
                ],
                'ranks_history' => [
                    [
                        'primary_isbn10' => '1401232019',
                        'primary_isbn13' => '9781401232016',
                        'rank' => 8,
                        'list_name' => 'Hardcover Graphic Books',
                        'display_name' => 'Hardcover Graphic Books',
                        'published_date' => '2011-11-13',
                        'bestsellers_date' => '2011-10-29',
                        'weeks_on_list' => 2,
                        'rank_last_week' => 0,
                        'asterisk' => 0,
                        'dagger' => 0,
                    ],
                    [
                        'primary_isbn10' => '1401232019',
                        'primary_isbn13' => '9781401232016',
                        'rank' => 6,
                        'list_name' => 'Hardcover Graphic Books',
                        'display_name' => 'Hardcover Graphic Books',
                        'published_date' => '2011-11-06',
                        'bestsellers_date' => '2011-10-22',
                        'weeks_on_list' => 1,
                        'rank_last_week' => 0,
                        'asterisk' => 0,
                        'dagger' => 0,
                    ],
                ],
                'reviews' => [
                    [
                        'book_review_link' => '',
                        'first_chapter_link' => '',
                        'sunday_review_link' => '',
                        'article_chapter_link' => '',
                    ],
                ],
            ],
            [
                'title' => '100 BULLETS: DELUXE EDITION, BOOK FOUR',
                'description' => 'This deluxe edition of the noir series, about a man named Graves who gives wronged people an untraceable gun to exact revenge, collects issues 59 through 80.',
                'contributor' => 'by Brian Azzarello and Eduardo Risso',
                'author' => 'Brian Azzarello and Eduardo Risso',
                'contributor_note' => '',
                'price' => '0.00',
                'age_group' => '',
                'publisher' => 'DC Comics',
                'isbns' => [
                    [
                        'isbn10' => '1401238076',
                        'isbn13' => '9781401238070',
                    ],
                ],
                'ranks_history' => [
                    [
                        'primary_isbn10' => '1401238076',
                        'primary_isbn13' => '9781401238070',
                        'rank' => 4,
                        'list_name' => 'Hardcover Graphic Books',
                        'display_name' => 'Hardcover Graphic Books',
                        'published_date' => '2013-05-26',
                        'bestsellers_date' => '2013-05-11',
                        'weeks_on_list' => 4,
                        'rank_last_week' => 0,
                        'asterisk' => 0,
                        'dagger' => 0,
                    ],
                    [
                        'primary_isbn10' => '1401238076',
                        'primary_isbn13' => '9781401238070',
                        'rank' => 9,
                        'list_name' => 'Hardcover Graphic Books',
                        'display_name' => 'Hardcover Graphic Books',
                        'published_date' => '2013-05-19',
                        'bestsellers_date' => '2013-05-04',
                        'weeks_on_list' => 3,
                        'rank_last_week' => 0,
                        'asterisk' => 0,
                        'dagger' => 0,
                    ],
                ],
                'reviews' => [
                    [
                        'book_review_link' => '',
                        'first_chapter_link' => '',
                        'sunday_review_link' => '',
                        'article_chapter_link' => '',
                    ],
                ],
            ],
            [
                'title' => 'FLASHPOINT: BATMAN',
                'description' => 'Batman is Thomas Wayne, whose son Bruce has died, and the parents of Dick Grayson are alive. This can only be an alternate universe.',
                'contributor' => 'by Brian Azzarello and Eduardo Risso',
                'author' => 'Brian Azzarello and Eduardo Risso',
                'contributor_note' => '',
                'price' => '17.99',
                'age_group' => '',
                'publisher' => 'DC Comics',
                'isbns' => [],
                'ranks_history' => [
                    [
                        'primary_isbn10' => 'None',
                        'primary_isbn13' => '9781401234058',
                        'rank' => 10,
                        'list_name' => 'Paperback Graphic Books',
                        'display_name' => 'Paperback Graphic Books',
                        'published_date' => '2012-04-08',
                        'bestsellers_date' => '2012-03-24',
                        'weeks_on_list' => 1,
                        'rank_last_week' => 0,
                        'asterisk' => 0,
                        'dagger' => 0,
                    ],
                ],
                'reviews' => [
                    [
                        'book_review_link' => '',
                        'first_chapter_link' => '',
                        'sunday_review_link' => '',
                        'article_chapter_link' => '',
                    ],
                ],
            ],
            [
                'title' => 'SPACEMAN: DELUXE EDITION',
                'description' => 'The team behind "100 Bullets" tells the intersellar tale of Orson, a genetically engineered outcast looking for a better life.',
                'contributor' => 'by Brian Azzarello and Eduardo Risso',
                'author' => 'Brian Azzarello and Eduardo Risso',
                'contributor_note' => '',
                'price' => '24.99',
                'age_group' => '',
                'publisher' => 'DC Comics',
                'isbns' => [
                    [
                        'isbn10' => '1401235522',
                        'isbn13' => '9781401235529',
                    ],
                ],
                'ranks_history' => [
                    [
                        'primary_isbn10' => '1401235522',
                        'primary_isbn13' => '9781401235529',
                        'rank' => 5,
                        'list_name' => 'Hardcover Graphic Books',
                        'display_name' => 'Hardcover Graphic Books',
                        'published_date' => '2012-12-02',
                        'bestsellers_date' => '2012-11-17',
                        'weeks_on_list' => 1,
                        'rank_last_week' => 0,
                        'asterisk' => 0,
                        'dagger' => 0,
                    ],
                ],
                'reviews' => [
                    [
                        'book_review_link' => '',
                        'first_chapter_link' => '',
                        'sunday_review_link' => '',
                        'article_chapter_link' => '',
                    ],
                ],
            ],
        ],
    ];
}
