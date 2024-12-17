<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Auth Rules
    // --------------------------------------------------------------------

    public array $login = [
        'username' => [
            'rules'  => 'required|min_length[5]|max_length[16]',
            'errors' => [
                'required' => 'Username tidak boleh kosong.',
                'min_length' => 'Username harus minimal 5 karakter.',
                'max_length' => 'Username tidak boleh lebih dari 16 karakter.',
            ],
        ],
        'password' => [
            'rules'  => 'required|min_length[5]|max_length[132]',
            'errors' => [
                'required' => 'Password tidak boleh kosong.',
                'min_length' => 'Password harus minimal 5 karakter.',
                'max_length' => 'Password tidak boleh lebih dari 132 karakter.',
            ]
        ],
    ];

    public array $register = [
        'name' => [
            'rules'  => 'required|min_length[4]|max_length[32]',
            'errors' => [
                'required'    => 'Nama tidak boleh kosong.',
                'min_length'  => 'Nama harus minimal 4 karakter.',
                'max_length'  => 'Nama tidak boleh lebih dari 32 karakter.',
            ],
        ],
        'username' => [
            'rules'  => 'required|min_length[5]|max_length[16]|is_unique[users.username]|regex_match[/^[a-zA-Z0-9_.]+$/]',
            'errors' => [
                'required'    => 'Username tidak boleh kosong.',
                'min_length'  => 'Username harus minimal 5 karakter.',
                'max_length'  => 'Username tidak boleh lebih dari 16 karakter.',
                'is_unique'   => 'Username sudah digunakan, pilih username yang lain.',
                'regex_match' => 'Username hanya boleh mengandung huruf, angka, underscore (_) dan dot (.)'
            ],
        ],
        'email' => [
            'rules'  => 'required|min_length[3]|max_length[64]|valid_email|is_unique[users.email]',
            'errors' => [
                'required'    => 'Email tidak boleh kosong.',
                'min_length'  => 'Email harus minimal 4 karakter.',
                'max_length'  => 'Email tidak boleh lebih dari 64 karakter.',
                'valid_email' => 'Email harus merupakan alamat email yang valid.',
                'is_unique'   => 'Email sudah digunakan, gunakan alamat email yang lain.'
            ],
        ],
        'password' => [
            'rules'  => 'required|min_length[8]|max_length[132]',
            'errors' => [
                'required'   => 'Password tidak boleh kosong.',
                'min_length' => 'Password harus minimal 8 karakter.',
                'max_length' => 'Password tidak boleh lebih dari 132 karakter.',
            ]
        ],
        'retype_password' => [
            'rules'  => 'required|min_length[8]|max_length[132]|matches[password]',
            'errors' => [
                'required'   => 'Ulangi Password tidak boleh kosong.',
                'min_length' => 'Ulangi Password harus minimal 8 karakter.',
                'max_length' => 'Ulangi Password tidak boleh lebih dari 132 karakter.',
                'matches'    => 'Ulangi Password harus sama dengan Password.'
            ]
        ],
    ];


    // --------------------------------------------------------------------
    // Game Rules
    // --------------------------------------------------------------------

    public array $game = [
        'game_name' => [
            'rules'  => 'required|min_length[4]|max_length[64]',
            'errors' => [
                'required' => 'Nama game tidak boleh kosong.',
                'min_length' => 'Nama game harus minimal 4 karakter.',
                'max_length' => 'Nama game tidak boleh lebih dari 64 karakter.',
            ],
        ],
        'game_code' => [
            'rules'  => 'required|min_length[4]|max_length[32]',
            'errors' => [
                'required' => 'Kode game tidak boleh kosong.',
                'min_length' => 'Kode game harus minimal 4 karakter.',
                'max_length' => 'Kode game tidak boleh lebih dari 32 karakter.',
            ],
        ],
        'game_description' => [
            'rules'  => 'required|min_length[8]',
            'errors' => [
                'required' => 'Deskripsi game tidak boleh kosong.',
                'min_length' => 'Deskripsi game harus minimal 8 karakter.',
            ]
        ],
        'game_image' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Gambar game harus wajib ada.',
            ]
        ],
        'game_max_player' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Maksimal player game tidak boleh kosong.',
            ]
        ],
        'game_creator' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Terjadi kesalahan (creator), Silahkan coba lagi.',
            ]
        ],
        'game_is_verified' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Terjadi kesalahan (verified), Silahkan coba lagi.',
            ]
        ],
    ];

    public array $gameAccount = [
        'account_identity' => [
            'rules'  => 'required|min_length[6]|max_length[32]',
            'errors' => [
                'required' => 'User Id tidak boleh kosong.',
                'min_length' => 'User Id harus minimal 6 karakter.',
                'max_length' => 'User Id tidak boleh lebih dari 32 karakter.',
            ],
        ],
        'account_identity_zone_id' => [
            'rules'  => 'max_length[16]',
            'errors' => [
                'max_length' => 'Zone Id tidak boleh lebih dari 16 karakter.',
            ],
        ],
        'account_game' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Game harus dipilih untuk menambahkan akun game tersebut.',
            ],
        ],
        'account_user' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Terjadi kesalahan pada akunmu, silahkan coba lagi.',
            ],
        ],
        'account_status' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Terjadi kesalahan pada saat memverifikasi status akun ini, silahkan coba lagi.',
            ],
        ],
    ];

    // --------------------------------------------------------------------
    // Team Rules
    // --------------------------------------------------------------------

    public array $team = [
        'team_name' => [
            'rules'  => 'required|min_length[4]|max_length[64]',
            'errors' => [
                'required' => 'Nama tim tidak boleh kosong.',
                'min_length' => 'Nama tim harus minimal 4 karakter.',
                'max_length' => 'Nama tim tidak boleh lebih dari 64 karakter.',
            ],
        ],
        'team_code' => [
            'rules'  => 'required|min_length[4]|max_length[32]',
            'errors' => [
                'required' => 'Kode tim tidak boleh kosong.',
                'min_length' => 'Kode tim harus minimal 4 karakter.',
                'max_length' => 'Kode tim tidak boleh lebih dari 32 karakter.',
            ],
        ],
        'team_status' => [
            'rules'  => 'required|in_list[draft,recruite,matches,archive]',
            'errors' => [
                'required' => 'Status tim harus dipilih.',
                'in_list' => 'Status tim harus salah satu dari "draft", "recruite", "matches", atau "archive".',
            ]
        ],
        'team_creator' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Terjadi kesalahan (creator), Silahkan coba lagi.',
            ]
        ],
        'team_game' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Game harus dipilih.',
            ]
        ],
    ];

    public array $teamMember = [
        'team_member_hero' => [
            'rules'  => 'required|min_length[4]|max_length[64]',
            'errors' => [
                'required' => 'Hero tidak boleh kosong.',
                'min_length' => 'Hero harus minimal 4 karakter.',
                'max_length' => 'Hero tidak boleh lebih dari 64 karakter.',
            ],
        ],
        'team_member_hero_role' => [
            'rules'  => 'required|min_length[4]|max_length[32]',
            'errors' => [
                'required' => 'Role hero tidak boleh kosong.',
                'min_length' => 'Role hero harus minimal 4 karakter.',
                'max_length' => 'Role hero tidak boleh lebih dari 32 karakter.',
            ],
        ],
        'team_member_hero_id' => [],
        'team_member_hero_image' => [],
        'team_member_team' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Terjadi kesalahan (team id), Silahkan coba lagi.',
            ]
        ],
        'team_member_account' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Akun game harus dipilih.',
            ]
        ],
    ];

    // --------------------------------------------------------------------
    // User Profile Rules
    // --------------------------------------------------------------------

    public array $userProfile = [
        'name' => [
            'rules'  => 'required|min_length[4]|max_length[32]',
            'errors' => [
                'required'    => 'Nama tidak boleh kosong.',
                'min_length'  => 'Nama harus minimal 4 karakter.',
                'max_length'  => 'Nama tidak boleh lebih dari 32 karakter.',
            ],
        ],
        'username' => [
            'rules'  => 'required|min_length[5]|max_length[16]|regex_match[/^[a-zA-Z0-9_.]+$/]',
            'errors' => [
                'required'    => 'Username tidak boleh kosong.',
                'min_length'  => 'Username harus minimal 5 karakter.',
                'max_length'  => 'Username tidak boleh lebih dari 16 karakter.',
                'regex_match' => 'Username hanya boleh mengandung huruf, angka, underscore (_) dan dot (.)'
            ],
        ],
        'email' => [
            'rules'  => 'required|min_length[3]|max_length[64]|valid_email',
            'errors' => [
                'required'    => 'Email tidak boleh kosong.',
                'min_length'  => 'Email harus minimal 4 karakter.',
                'max_length'  => 'Email tidak boleh lebih dari 64 karakter.',
                'valid_email' => 'Email harus merupakan alamat email yang valid.',
            ],
        ],
        'phone' => [
            'rules'  => 'regex_match[/\+(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|2[98654321]\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)\d{1,14}$/]',
            'errors' => [
                'regex_match'    => 'Nomor Telepon tidak valid.',
            ],
        ],
        'password' => [],
        'photo' => [
            'rules'  => 'required',
            'errors' => [
                'required'   => 'Foto tidak boleh kosong dan harus dipilih.',
            ]
        ],
    ];
}
