<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Choice;
use App\Models\Novelty;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class QuizQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $novelties = Novelty::all();

        // Créer 15 quiz avec 5 questions chacun
        $quizData = [
            [
                'name' => 'Breitling Heritage & History',
                'description' => 'Test your knowledge of Breitling\'s rich heritage and historical milestones',
                'novelty_id' => $novelties->where('badge.name', 'Heritage Specialist')->first()->id,
                'questions' => [
                    [
                        'texte' => 'In what year was Breitling founded by Léon Breitling?',
                        'choices' => [
                            ['texte' => '1884', 'correcte' => true],
                            ['texte' => '1890', 'correcte' => false],
                            ['texte' => '1875', 'correcte' => false],
                            ['texte' => '1892', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What was the first patented development by Léon Breitling that helped Swiss Police issue speed tickets?',
                        'choices' => [
                            ['texte' => 'The "Vitesse" pocket chronograph', 'correcte' => true],
                            ['texte' => 'The mono-pusher wrist chronograph', 'correcte' => false],
                            ['texte' => 'The slide rule bezel', 'correcte' => false],
                            ['texte' => 'The automatic winding system', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which Breitling timepiece became the official supplier to the World Aviation?',
                        'choices' => [
                            ['texte' => 'Navitimer', 'correcte' => true],
                            ['texte' => 'Superocean', 'correcte' => false],
                            ['texte' => 'Avenger', 'correcte' => false],
                            ['texte' => 'Premier', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What year did Breitling introduce the first wrist-worn chronograph?',
                        'choices' => [
                            ['texte' => '1915', 'correcte' => true],
                            ['texte' => '1920', 'correcte' => false],
                            ['texte' => '1912', 'correcte' => false],
                            ['texte' => '1918', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which city serves as Breitling\'s headquarters?',
                        'choices' => [
                            ['texte' => 'Grenchen', 'correcte' => true],
                            ['texte' => 'Geneva', 'correcte' => false],
                            ['texte' => 'Basel', 'correcte' => false],
                            ['texte' => 'La Chaux-de-Fonds', 'correcte' => false],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Aviation Excellence',
                'description' => 'Master Breitling\'s deep connection with aviation and aeronautics',
                'novelty_id' => $novelties->where('badge.name', 'Aviation Expert')->first()->id,
                'questions' => [
                    [
                        'texte' => 'What does AOPA stand for in relation to Breitling\'s aviation partnerships?',
                        'choices' => [
                            ['texte' => 'Aircraft Owners and Pilots Association', 'correcte' => true],
                            ['texte' => 'Aviation Operations and Pilot Academy', 'correcte' => false],
                            ['texte' => 'Aeronautical Organization of Professional Aviators', 'correcte' => false],
                            ['texte' => 'Advanced Operations Pilot Association', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which Breitling watch features a circular slide rule for aviation calculations?',
                        'choices' => [
                            ['texte' => 'Navitimer', 'correcte' => true],
                            ['texte' => 'Avenger', 'correcte' => false],
                            ['texte' => 'Superocean', 'correcte' => false],
                            ['texte' => 'Premier', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What aviation calculation can be performed using the Navitimer\'s slide rule?',
                        'choices' => [
                            ['texte' => 'Fuel consumption, distance, and speed calculations', 'correcte' => true],
                            ['texte' => 'Only altitude measurements', 'correcte' => false],
                            ['texte' => 'Weather pattern analysis', 'correcte' => false],
                            ['texte' => 'Radio frequency calculations', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which aerobatic team has partnered with Breitling?',
                        'choices' => [
                            ['texte' => 'Breitling Jet Team', 'correcte' => true],
                            ['texte' => 'Blue Angels', 'correcte' => false],
                            ['texte' => 'Red Arrows', 'correcte' => false],
                            ['texte' => 'Thunderbirds', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What is the significance of the 24-hour scale on aviation Breitling watches?',
                        'choices' => [
                            ['texte' => 'It allows pilots to distinguish between AM and PM times', 'correcte' => true],
                            ['texte' => 'It measures flight duration only', 'correcte' => false],
                            ['texte' => 'It calculates time zones automatically', 'correcte' => false],
                            ['texte' => 'It measures fuel consumption rates', 'correcte' => false],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Chronometer Precision',
                'description' => 'Understand the precision and certification standards of Breitling timepieces',
                'novelty_id' => $novelties->where('badge.name', 'Chronomètre Master')->first()->id,
                'questions' => [
                    [
                        'texte' => 'What does COSC stand for in watch certification?',
                        'choices' => [
                            ['texte' => 'Contrôle Officiel Suisse des Chronomètres', 'correcte' => true],
                            ['texte' => 'Certified Official Swiss Chronometer', 'correcte' => false],
                            ['texte' => 'Central Organization of Swiss Clockmakers', 'correcte' => false],
                            ['texte' => 'Certification Office for Swiss Chronographs', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What is the daily rate tolerance for a COSC-certified chronometer?',
                        'choices' => [
                            ['texte' => '-4 to +6 seconds per day', 'correcte' => true],
                            ['texte' => '-2 to +2 seconds per day', 'correcte' => false],
                            ['texte' => '-10 to +10 seconds per day', 'correcte' => false],
                            ['texte' => '-1 to +1 second per day', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'How many days does the COSC testing process take?',
                        'choices' => [
                            ['texte' => '15 days', 'correcte' => true],
                            ['texte' => '7 days', 'correcte' => false],
                            ['texte' => '30 days', 'correcte' => false],
                            ['texte' => '21 days', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'At how many different positions is a movement tested during COSC certification?',
                        'choices' => [
                            ['texte' => '5 positions', 'correcte' => true],
                            ['texte' => '3 positions', 'correcte' => false],
                            ['texte' => '6 positions', 'correcte' => false],
                            ['texte' => '4 positions', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What percentage of Breitling mechanical watches are COSC-certified chronometers?',
                        'choices' => [
                            ['texte' => '100%', 'correcte' => true],
                            ['texte' => '95%', 'correcte' => false],
                            ['texte' => '80%', 'correcte' => false],
                            ['texte' => '90%', 'correcte' => false],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Navitimer Mastery',
                'description' => 'Deep dive into the iconic Navitimer collection and its features',
                'novelty_id' => $novelties->where('badge.name', 'Navitimer Specialist')->first()->id,
                'questions' => [
                    [
                        'texte' => 'In what year was the original Navitimer launched?',
                        'choices' => [
                            ['texte' => '1952', 'correcte' => true],
                            ['texte' => '1955', 'correcte' => false],
                            ['texte' => '1950', 'correcte' => false],
                            ['texte' => '1958', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What is the standard case diameter of the modern Navitimer 1?',
                        'choices' => [
                            ['texte' => '41mm', 'correcte' => true],
                            ['texte' => '43mm', 'correcte' => false],
                            ['texte' => '38mm', 'correcte' => false],
                            ['texte' => '46mm', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which bezel type is characteristic of the Navitimer?',
                        'choices' => [
                            ['texte' => 'Circular slide rule bezel', 'correcte' => true],
                            ['texte' => 'Unidirectional rotating bezel', 'correcte' => false],
                            ['texte' => 'Fixed smooth bezel', 'correcte' => false],
                            ['texte' => 'Tachymeter bezel', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What is the power reserve of the Breitling Manufacture Caliber 01 in the Navitimer?',
                        'choices' => [
                            ['texte' => 'Approximately 70 hours', 'correcte' => true],
                            ['texte' => '48 hours', 'correcte' => false],
                            ['texte' => '40 hours', 'correcte' => false],
                            ['texte' => '60 hours', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which movement type powers the modern Navitimer 1?',
                        'choices' => [
                            ['texte' => 'Automatic chronograph', 'correcte' => true],
                            ['texte' => 'Manual wind chronograph', 'correcte' => false],
                            ['texte' => 'Quartz chronograph', 'correcte' => false],
                            ['texte' => 'Automatic time-only', 'correcte' => false],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Superocean Depths',
                'description' => 'Explore the professional diving capabilities of the Superocean collection',
                'novelty_id' => $novelties->where('badge.name', 'Superocean Expert')->first()->id,
                'questions' => [
                    [
                        'texte' => 'What is the water resistance of the Superocean Automatic?',
                        'choices' => [
                            ['texte' => '1000m (3300ft)', 'correcte' => true],
                            ['texte' => '500m (1650ft)', 'correcte' => false],
                            ['texte' => '300m (1000ft)', 'correcte' => false],
                            ['texte' => '2000m (6600ft)', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which safety feature is essential for diving watches like the Superocean?',
                        'choices' => [
                            ['texte' => 'Unidirectional rotating bezel', 'correcte' => true],
                            ['texte' => 'Bidirectional bezel', 'correcte' => false],
                            ['texte' => 'Fixed bezel', 'correcte' => false],
                            ['texte' => 'Digital display', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What is the helium escape valve designed for?',
                        'choices' => [
                            ['texte' => 'Saturation diving and decompression', 'correcte' => true],
                            ['texte' => 'Regular underwater activities', 'correcte' => false],
                            ['texte' => 'Surface swimming only', 'correcte' => false],
                            ['texte' => 'Aviation at high altitudes', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which certification standard do professional diving watches meet?',
                        'choices' => [
                            ['texte' => 'ISO 6425', 'correcte' => true],
                            ['texte' => 'ISO 9001', 'correcte' => false],
                            ['texte' => 'COSC only', 'correcte' => false],
                            ['texte' => 'NASA standards', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What material is commonly used for the Superocean\'s case construction?',
                        'choices' => [
                            ['texte' => 'Stainless steel', 'correcte' => true],
                            ['texte' => 'Titanium only', 'correcte' => false],
                            ['texte' => 'Gold only', 'correcte' => false],
                            ['texte' => 'Carbon fiber', 'correcte' => false],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Premier Elegance',
                'description' => 'Discover the sophisticated Premier collection and its refined aesthetics',
                'novelty_id' => $novelties->where('badge.name', 'Premier Connoisseur')->first()->id,
                'questions' => [
                    [
                        'texte' => 'What design philosophy characterizes the Premier collection?',
                        'choices' => [
                            ['texte' => 'Elegant simplicity with vintage inspiration', 'correcte' => true],
                            ['texte' => 'Professional sports functionality', 'correcte' => false],
                            ['texte' => 'Aviation-focused design', 'correcte' => false],
                            ['texte' => 'Military tactical aesthetics', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which case shape is typical of the Premier collection?',
                        'choices' => [
                            ['texte' => 'Round with thin profile', 'correcte' => true],
                            ['texte' => 'Square case', 'correcte' => false],
                            ['texte' => 'Tonneau shape', 'correcte' => false],
                            ['texte' => 'Oversized cushion case', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What type of complications are featured in the Premier collection?',
                        'choices' => [
                            ['texte' => 'Chronograph and calendar functions', 'correcte' => true],
                            ['texte' => 'Diving bezels and depth meters', 'correcte' => false],
                            ['texte' => 'Aviation slide rules', 'correcte' => false],
                            ['texte' => 'Military timing functions', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which dial finish is commonly used in the Premier collection?',
                        'choices' => [
                            ['texte' => 'Sunray finish', 'correcte' => true],
                            ['texte' => 'Matte black finish', 'correcte' => false],
                            ['texte' => 'Carbon fiber pattern', 'correcte' => false],
                            ['texte' => 'Military green', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What strap options are typically available for the Premier collection?',
                        'choices' => [
                            ['texte' => 'Leather straps and steel bracelets', 'correcte' => true],
                            ['texte' => 'Rubber straps only', 'correcte' => false],
                            ['texte' => 'NATO straps only', 'correcte' => false],
                            ['texte' => 'Mesh bracelets only', 'correcte' => false],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Avenger Robustness',
                'description' => 'Master the robust and military-inspired Avenger collection',
                'novelty_id' => $novelties->where('badge.name', 'Avenger Specialist')->first()->id,
                'questions' => [
                    [
                        'texte' => 'What is the water resistance of the Avenger collection?',
                        'choices' => [
                            ['texte' => '300m (1000ft)', 'correcte' => true],
                            ['texte' => '100m (330ft)', 'correcte' => false],
                            ['texte' => '500m (1650ft)', 'correcte' => false],
                            ['texte' => '50m (165ft)', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which feature distinguishes the Avenger crown?',
                        'choices' => [
                            ['texte' => 'Non-slip grip pattern and crown guards', 'correcte' => true],
                            ['texte' => 'Standard smooth crown', 'correcte' => false],
                            ['texte' => 'Push-button crown', 'correcte' => false],
                            ['texte' => 'Screw-down crown only', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What case material options are available in the Avenger collection?',
                        'choices' => [
                            ['texte' => 'Steel, titanium, and DLC coating', 'correcte' => true],
                            ['texte' => 'Gold only', 'correcte' => false],
                            ['texte' => 'Plastic composite', 'correcte' => false],
                            ['texte' => 'Aluminum only', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which military specification does the Avenger meet?',
                        'choices' => [
                            ['texte' => 'Military robustness standards', 'correcte' => true],
                            ['texte' => 'Commercial diving standards only', 'correcte' => false],
                            ['texte' => 'Aviation standards only', 'correcte' => false],
                            ['texte' => 'No specific military standards', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What is the typical case size range for the Avenger collection?',
                        'choices' => [
                            ['texte' => '42mm to 50mm', 'correcte' => true],
                            ['texte' => '36mm to 40mm', 'correcte' => false],
                            ['texte' => '38mm to 42mm', 'correcte' => false],
                            ['texte' => '28mm to 35mm', 'correcte' => false],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Chronoliner Travel',
                'description' => 'Explore the dual-timezone capabilities of the Chronoliner',
                'novelty_id' => $novelties->where('badge.name', 'Chronoliner Expert')->first()->id,
                'questions' => [
                    [
                        'texte' => 'What is the primary function of the Chronoliner?',
                        'choices' => [
                            ['texte' => 'Dual-timezone chronograph', 'correcte' => true],
                            ['texte' => 'Single timezone chronograph', 'correcte' => false],
                            ['texte' => 'Diving chronograph', 'correcte' => false],
                            ['texte' => 'Aviation calculator only', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'How is the second timezone displayed on the Chronoliner?',
                        'choices' => [
                            ['texte' => 'Red-tipped GMT hand on 24-hour scale', 'correcte' => true],
                            ['texte' => 'Digital display', 'correcte' => false],
                            ['texte' => 'Separate subdial', 'correcte' => false],
                            ['texte' => 'Rotating bezel indication', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What is the case diameter of the Chronoliner?',
                        'choices' => [
                            ['texte' => '46mm', 'correcte' => true],
                            ['texte' => '42mm', 'correcte' => false],
                            ['texte' => '44mm', 'correcte' => false],
                            ['texte' => '48mm', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which bezel type does the Chronoliner feature?',
                        'choices' => [
                            ['texte' => 'Bidirectional rotating bezel', 'correcte' => true],
                            ['texte' => 'Unidirectional diving bezel', 'correcte' => false],
                            ['texte' => 'Fixed bezel', 'correcte' => false],
                            ['texte' => 'Slide rule bezel', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What movement powers the Chronoliner?',
                        'choices' => [
                            ['texte' => 'Breitling Caliber 04', 'correcte' => true],
                            ['texte' => 'Breitling Caliber 01', 'correcte' => false],
                            ['texte' => 'ETA 2824', 'correcte' => false],
                            ['texte' => 'Sellita SW500', 'correcte' => false],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Professional Instruments',
                'description' => 'Understand Breitling\'s professional instrument watches',
                'novelty_id' => $novelties->where('badge.name', 'Professional Master')->first()->id,
                'questions' => [
                    [
                        'texte' => 'What defines a professional instrument watch?',
                        'choices' => [
                            ['texte' => 'Precision, reliability, and functional design', 'correcte' => true],
                            ['texte' => 'Luxury materials only', 'correcte' => false],
                            ['texte' => 'Fashion-forward aesthetics', 'correcte' => false],
                            ['texte' => 'Smart connectivity features', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which certification ensures chronometer precision?',
                        'choices' => [
                            ['texte' => 'COSC certification', 'correcte' => true],
                            ['texte' => 'ISO 9001', 'correcte' => false],
                            ['texte' => 'CE marking', 'correcte' => false],
                            ['texte' => 'Swiss Made label only', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What is the purpose of a tachymeter scale?',
                        'choices' => [
                            ['texte' => 'Measuring speed over distance', 'correcte' => true],
                            ['texte' => 'Measuring diving depth', 'correcte' => false],
                            ['texte' => 'Calculating fuel consumption', 'correcte' => false],
                            ['texte' => 'Measuring altitude', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which hands configuration is typical for a chronograph?',
                        'choices' => [
                            ['texte' => 'Central chronograph seconds with subdials', 'correcte' => true],
                            ['texte' => 'Three main hands only', 'correcte' => false],
                            ['texte' => 'Digital display', 'correcte' => false],
                            ['texte' => 'Single hand configuration', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What is the function of a pusher on a chronograph?',
                        'choices' => [
                            ['texte' => 'Start, stop, and reset timing functions', 'correcte' => true],
                            ['texte' => 'Adjust the date', 'correcte' => false],
                            ['texte' => 'Activate the alarm', 'correcte' => false],
                            ['texte' => 'Change time zones', 'correcte' => false],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Movement Mechanics',
                'description' => 'Deep dive into Breitling\'s watchmaking movements and complications',
                'novelty_id' => $novelties->where('badge.name', 'Movement Specialist')->first()->id,
                'questions' => [
                    [
                        'texte' => 'What type of escapement is used in modern Breitling movements?',
                        'choices' => [
                            ['texte' => 'Swiss lever escapement', 'correcte' => true],
                            ['texte' => 'Duplex escapement', 'correcte' => false],
                            ['texte' => 'Verge escapement', 'correcte' => false],
                            ['texte' => 'Co-axial escapement', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'How many jewels are typically found in a Breitling automatic movement?',
                        'choices' => [
                            ['texte' => '25-47 jewels', 'correcte' => true],
                            ['texte' => '15-20 jewels', 'correcte' => false],
                            ['texte' => '7-17 jewels', 'correcte' => false],
                            ['texte' => '50+ jewels', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What is the frequency of a modern Breitling mechanical movement?',
                        'choices' => [
                            ['texte' => '28,800 vibrations per hour (4Hz)', 'correcte' => true],
                            ['texte' => '18,000 vibrations per hour (2.5Hz)', 'correcte' => false],
                            ['texte' => '36,000 vibrations per hour (5Hz)', 'correcte' => false],
                            ['texte' => '21,600 vibrations per hour (3Hz)', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What is the purpose of the rotor in an automatic movement?',
                        'choices' => [
                            ['texte' => 'Wind the mainspring through wrist movement', 'correcte' => true],
                            ['texte' => 'Regulate timekeeping precision', 'correcte' => false],
                            ['texte' => 'Display seconds indication', 'correcte' => false],
                            ['texte' => 'Control chronograph functions', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which component regulates the timing in a mechanical watch?',
                        'choices' => [
                            ['texte' => 'Balance wheel and hairspring', 'correcte' => true],
                            ['texte' => 'Mainspring only', 'correcte' => false],
                            ['texte' => 'Crown and stem', 'correcte' => false],
                            ['texte' => 'Case and crystal', 'correcte' => false],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Innovation & Future',
                'description' => 'Discover Breitling\'s latest innovations and future technologies',
                'novelty_id' => $novelties->where('badge.name', 'Innovation Pioneer')->first()->id,
                'questions' => [
                    [
                        'texte' => 'What digital passport technology does Breitling use for authentication?',
                        'choices' => [
                            ['texte' => 'Blockchain-based digital certificate', 'correcte' => true],
                            ['texte' => 'QR code system', 'correcte' => false],
                            ['texte' => 'RFID chips', 'correcte' => false],
                            ['texte' => 'Serial number only', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which sustainable practice has Breitling adopted?',
                        'choices' => [
                            ['texte' => 'ECONYL recycled nylon straps', 'correcte' => true],
                            ['texte' => 'Single-use packaging', 'correcte' => false],
                            ['texte' => 'No sustainability initiatives', 'correcte' => false],
                            ['texte' => 'Plastic case materials', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What innovation does the SuperQuartz movement represent?',
                        'choices' => [
                            ['texte' => 'COSC-certified quartz precision', 'correcte' => true],
                            ['texte' => 'Solar-powered movement', 'correcte' => false],
                            ['texte' => 'Kinetic energy movement', 'correcte' => false],
                            ['texte' => 'Atomic timekeeping', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which material innovation has Breitling introduced for lightweight cases?',
                        'choices' => [
                            ['texte' => 'Breitlight polymer', 'correcte' => true],
                            ['texte' => 'Standard plastic', 'correcte' => false],
                            ['texte' => 'Wooden cases', 'correcte' => false],
                            ['texte' => 'Paper composites', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What connectivity feature do some modern Breitling watches offer?',
                        'choices' => [
                            ['texte' => 'Smartphone connectivity for notifications', 'correcte' => true],
                            ['texte' => 'GPS tracking only', 'correcte' => false],
                            ['texte' => 'No connectivity features', 'correcte' => false],
                            ['texte' => 'Radio wave synchronization', 'correcte' => false],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Craftsmanship & Art',
                'description' => 'Appreciate the artisanal craftsmanship in Breitling timepieces',
                'novelty_id' => $novelties->where('badge.name', 'Craftsmanship Expert')->first()->id,
                'questions' => [
                    [
                        'texte' => 'What finishing technique is applied to Breitling movement bridges?',
                        'choices' => [
                            ['texte' => 'Côtes de Genève (Geneva stripes)', 'correcte' => true],
                            ['texte' => 'Sandblasting only', 'correcte' => false],
                            ['texte' => 'Mirror polishing only', 'correcte' => false],
                            ['texte' => 'No finishing applied', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which hand-finishing technique is used on screws?',
                        'choices' => [
                            ['texte' => 'Blued steel screws with polished heads', 'correcte' => true],
                            ['texte' => 'Raw steel screws', 'correcte' => false],
                            ['texte' => 'Plastic screws', 'correcte' => false],
                            ['texte' => 'Painted screws', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What dial manufacturing technique creates depth and texture?',
                        'choices' => [
                            ['texte' => 'Multi-layer construction with applied indices', 'correcte' => true],
                            ['texte' => 'Single layer printing', 'correcte' => false],
                            ['texte' => 'Sticker application', 'correcte' => false],
                            ['texte' => 'Digital printing only', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which hand-crafting process is used for leather straps?',
                        'choices' => [
                            ['texte' => 'Hand-stitched with contrast thread', 'correcte' => true],
                            ['texte' => 'Machine gluing only', 'correcte' => false],
                            ['texte' => 'Stapling process', 'correcte' => false],
                            ['texte' => 'Heat welding', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What quality control process does each Breitling watch undergo?',
                        'choices' => [
                            ['texte' => 'Individual testing and certification', 'correcte' => true],
                            ['texte' => 'Batch testing only', 'correcte' => false],
                            ['texte' => 'No quality control', 'correcte' => false],
                            ['texte' => 'Visual inspection only', 'correcte' => false],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Limited Editions & Collectibles',
                'description' => 'Explore Breitling\'s exclusive limited editions and collector pieces',
                'novelty_id' => $novelties->where('badge.name', 'Limited Edition Collector')->first()->id,
                'questions' => [
                    [
                        'texte' => 'What makes a limited edition Breitling valuable to collectors?',
                        'choices' => [
                            ['texte' => 'Unique design, limited production, and provenance', 'correcte' => true],
                            ['texte' => 'Higher price only', 'correcte' => false],
                            ['texte' => 'Different movement', 'correcte' => false],
                            ['texte' => 'Larger case size', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which partnership has resulted in notable Breitling limited editions?',
                        'choices' => [
                            ['texte' => 'Aviation teams and aerospace organizations', 'correcte' => true],
                            ['texte' => 'Fashion brands only', 'correcte' => false],
                            ['texte' => 'Automotive companies only', 'correcte' => false],
                            ['texte' => 'No partnerships', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What authentication feature is included with limited editions?',
                        'choices' => [
                            ['texte' => 'Certificate of authenticity and unique serial number', 'correcte' => true],
                            ['texte' => 'Standard warranty card only', 'correcte' => false],
                            ['texte' => 'No special authentication', 'correcte' => false],
                            ['texte' => 'Verbal confirmation only', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which design elements often distinguish limited editions?',
                        'choices' => [
                            ['texte' => 'Special dial colors, unique engravings, or commemorative text', 'correcte' => true],
                            ['texte' => 'Identical to regular models', 'correcte' => false],
                            ['texte' => 'Different brand name', 'correcte' => false],
                            ['texte' => 'Non-functional complications', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'How are limited edition production numbers typically communicated?',
                        'choices' => [
                            ['texte' => 'Engraved on case back (e.g., "1 of 1000")', 'correcte' => true],
                            ['texte' => 'Separate paper certificate only', 'correcte' => false],
                            ['texte' => 'Digital display on watch', 'correcte' => false],
                            ['texte' => 'Not communicated', 'correcte' => false],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Certification Standards',
                'description' => 'Master the various certification standards in Breitling timepieces',
                'novelty_id' => $novelties->where('badge.name', 'Certification Master')->first()->id,
                'questions' => [
                    [
                        'texte' => 'What does the "Swiss Made" label guarantee?',
                        'choices' => [
                            ['texte' => 'Movement, assembly, and inspection in Switzerland', 'correcte' => true],
                            ['texte' => 'Case manufacturing only', 'correcte' => false],
                            ['texte' => 'Brand origin only', 'correcte' => false],
                            ['texte' => 'No specific requirements', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which temperature range is used for COSC chronometer testing?',
                        'choices' => [
                            ['texte' => '8°C, 23°C, and 38°C', 'correcte' => true],
                            ['texte' => '0°C and 50°C only', 'correcte' => false],
                            ['texte' => 'Room temperature only', 'correcte' => false],
                            ['texte' => '10°C and 30°C only', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What is the minimum Swiss content requirement for "Swiss Made"?',
                        'choices' => [
                            ['texte' => '60% of manufacturing costs', 'correcte' => true],
                            ['texte' => '50% of manufacturing costs', 'correcte' => false],
                            ['texte' => '80% of manufacturing costs', 'correcte' => false],
                            ['texte' => '30% of manufacturing costs', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which organization oversees COSC certification?',
                        'choices' => [
                            ['texte' => 'Official Swiss Chronometer Testing Institute', 'correcte' => true],
                            ['texte' => 'Individual watch manufacturers', 'correcte' => false],
                            ['texte' => 'European Union standards body', 'correcte' => false],
                            ['texte' => 'International trade organization', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What additional testing does Breitling perform beyond COSC?',
                        'choices' => [
                            ['texte' => 'Final assembly testing and quality control', 'correcte' => true],
                            ['texte' => 'No additional testing', 'correcte' => false],
                            ['texte' => 'Only visual inspection', 'correcte' => false],
                            ['texte' => 'Packaging verification only', 'correcte' => false],
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Brand Ambassador Mastery',
                'description' => 'Comprehensive knowledge test for Breitling brand ambassadors',
                'novelty_id' => $novelties->where('badge.name', 'Breitling Ambassador')->first()->id,
                'questions' => [
                    [
                        'texte' => 'What is Breitling\'s brand mission statement?',
                        'choices' => [
                            ['texte' => 'Instruments for professionals and adventurers', 'correcte' => true],
                            ['texte' => 'Luxury timepieces for elite clientele', 'correcte' => false],
                            ['texte' => 'Fashion accessories for modern lifestyle', 'correcte' => false],
                            ['texte' => 'Smart technology integration', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'Which core values define the Breitling brand?',
                        'choices' => [
                            ['texte' => 'Purpose, action, and pioneering spirit', 'correcte' => true],
                            ['texte' => 'Luxury, exclusivity, and status', 'correcte' => false],
                            ['texte' => 'Technology, innovation, and connectivity', 'correcte' => false],
                            ['texte' => 'Tradition, heritage, and conservatism', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What customer experience should a Breitling ambassador provide?',
                        'choices' => [
                            ['texte' => 'Educational, inspiring, and professional guidance', 'correcte' => true],
                            ['texte' => 'High-pressure sales approach', 'correcte' => false],
                            ['texte' => 'Basic product information only', 'correcte' => false],
                            ['texte' => 'Price-focused discussions', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'How should technical complications be explained to customers?',
                        'choices' => [
                            ['texte' => 'Clear, benefit-focused explanations with demonstrations', 'correcte' => true],
                            ['texte' => 'Technical jargon and complex terminology', 'correcte' => false],
                            ['texte' => 'Reading from specification sheets', 'correcte' => false],
                            ['texte' => 'Avoiding technical discussions', 'correcte' => false],
                        ]
                    ],
                    [
                        'texte' => 'What after-sales support should be emphasized?',
                        'choices' => [
                            ['texte' => 'Comprehensive warranty, service network, and ongoing support', 'correcte' => true],
                            ['texte' => 'Basic warranty information only', 'correcte' => false],
                            ['texte' => 'No specific after-sales emphasis', 'correcte' => false],
                            ['texte' => 'Third-party service recommendations', 'correcte' => false],
                        ]
                    ]
                ]
            ]
        ];

        foreach ($quizData as $index => $quizInfo) {
            // Créer le quiz
            $quiz = Quiz::create([
                'name' => $quizInfo['name'],
                'description' => $quizInfo['description'],
                'date_realised' => Carbon::now()->subDays(rand(1, 30)),
                'earned_points' => 1000, // Points standard par quiz
            ]);

            // Créer les questions pour ce quiz
            foreach ($quizInfo['questions'] as $questionData) {
                $question = Question::create([
                    'texte' => $questionData['texte'],
                    'novelties_id' => $quizInfo['novelty_id'],
                ]);

                // Créer les choix pour cette question
                foreach ($questionData['choices'] as $choiceData) {
                    Choice::create([
                        'texte' => $choiceData['texte'],
                        'questions_id' => $question->id,
                        'correcte' => $choiceData['correcte'],
                    ]);
                }

                // Associer la question au quiz
                $quiz->questions()->attach($question->id);
            }
        }
    }
}
