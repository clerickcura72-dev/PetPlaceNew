<?php

namespace App\Support;

/**
 * The vaccines an owner can pick when booking, and the list shown on the
 * vaccination records card. Vaccination records are matched to these by name.
 */
class VaccineCatalog
{
    private const DOG = [
        ['key' => 'rabies',        'name' => 'Anti-rabies',                  'core' => true,  'info' => 'Protects against rabies, a fatal disease that can spread to people.'],
        ['key' => 'cdv',           'name' => 'Canine Distemper Virus (CDV)', 'core' => true,  'info' => 'Protects against a serious virus affecting the respiratory, digestive and nervous systems.'],
        ['key' => 'cav',           'name' => 'Canine Adenovirus Type 1 & 2', 'core' => true,  'info' => 'Protects against infectious hepatitis and respiratory illness.'],
        ['key' => 'cpv',           'name' => 'Canine Parvovirus (CPV)',      'core' => true,  'info' => 'Protects against a highly contagious virus that causes severe illness.'],
        ['key' => 'parainfluenza', 'name' => 'Canine Parainfluenza',         'core' => false, 'info' => 'Helps protect against a contagious respiratory infection (kennel cough).'],
        ['key' => 'lepto',         'name' => 'Leptospirosis',                'core' => false, 'info' => 'Helps protect against a bacterial infection that can affect the kidneys and liver.'],
        ['key' => 'lyme',          'name' => 'Lyme Disease',                 'core' => false, 'info' => 'Helps protect against tick-borne Lyme disease.'],
        ['key' => 'influenza',     'name' => 'Canine Influenza (Dog Flu)',   'core' => false, 'info' => 'Helps protect against a contagious canine respiratory illness.'],
        ['key' => 'corona',        'name' => 'Canine Coronavirus',           'core' => false, 'info' => 'May be considered for some dogs; ask your veterinarian.'],
        ['key' => 'bordetella',    'name' => 'Bordetella bronchiseptica',    'core' => false, 'info' => 'May help protect against kennel cough; ask your veterinarian if it applies.'],
    ];

    private const CAT = [
        ['key' => 'rabies',     'name' => 'Anti-rabies',                    'core' => true,  'info' => 'Protects against rabies, a fatal disease that can spread to people.'],
        ['key' => 'fpv',        'name' => 'Feline Panleukopenia (FPV)',     'core' => true,  'info' => 'Protects against a severe and highly contagious feline virus.'],
        ['key' => 'fcv',        'name' => 'Feline Calicivirus (FCV)',       'core' => true,  'info' => 'Protects against a common respiratory infection in cats.'],
        ['key' => 'fhv',        'name' => 'Feline Rhinotracheitis (FHV-1)', 'core' => true,  'info' => 'Protects against a herpesvirus that causes sneezing and eye infections.'],
        ['key' => 'felv',       'name' => 'Feline Leukemia (FeLV)',         'core' => false, 'info' => 'Helps protect against feline leukemia virus, especially for outdoor cats.'],
        ['key' => 'bordetella', 'name' => 'Bordetella bronchiseptica',      'core' => false, 'info' => 'May help protect against a respiratory infection; ask your veterinarian.'],
    ];

    public static function for(?string $petType): array
    {
        return match ($petType) {
            'dog'   => self::DOG,
            'cat'   => self::CAT,
            default => [],
        };
    }

    /** Every vaccine name, used for the vet's suggestion list. */
    public static function allNames(): array
    {
        return array_values(array_unique(array_merge(
            array_column(self::DOG, 'name'),
            array_column(self::CAT, 'name'),
        )));
    }
}
