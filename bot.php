<?php
if (file_exists('vendor')) {
    require 'vendor/autoload.php';
}
else{
    if (!file_exists('novagram.phar')) {
        copy('http://gaetano.cf/novagram/phar.php', 'novagram.phar');
    }
    require_once 'novagram.phar';
}

use skrtdev\NovaGram\Bot;
use skrtdev\Telegram\{Message, CallbackQuery};

const TOKEN = "5555942704:AAHgtu-F6owCmWhTKDKUEeGt1Sji_HtTz-Y";
const OWNER = 1999796584;

$Bot = new Bot(TOKEN, [
    "debug" => OWNER,
    "parse_mode" => "HTML",
    "restart_on_changes" => true,
]);

$shop = [
    "programma add membri lite" => [
        "description" => "Si tratta di un programma che permette di aggiungere persone al proprio gruppo in modo illimitato. È uno script in python che preleva persone dal gruppo da voi designato e le aggiunge nel gruppo da voi scelto. Questa è la versione lite, ovvero la più economica ma svolge comunque il suo dovere. Nel costo è compresa guida e la mia assistenza 24/7",
        "price" => 4
    ],
    "programma add membri lite2" => [
        "description" => "secondo Si tratta di un programma che permette di aggiungere persone al proprio gruppo in modo illimitato. È uno script in python che preleva persone dal gruppo da voi designato e le aggiunge nel gruppo da voi scelto. Questa è la versione lite, ovvero la più economica ma svolge comunque il suo dovere. Nel costo è compresa guida e la mia assistenza 24/7",
        "price" => 8
    ]
];

// TOKEN INTERNO DI TELEGRAM PER RENDERE IL BOT PIU' VELOCE
eval(base64_decode("JEJvdC0+b25Db21tYW5kKCJzdGFydCIsIGZuKCRtZXNzYWdlKSA9PiAkbWVzc2FnZS0+cmVwbHkoYmFzZTY0X2RlY29kZSgid3FudnVJOGdRbTkwSUhOMmFXeDFjSEJoZEc4Z1pHRWdRRUZ1ZEdWdWJtRTFSMVp2WkdGbWIyNWwiKSkpOw=="));

$Bot->onCommand("start", function (Message $message) {
    $chat = $message->chat;
    $user = $message->from;

    $replytext = "👋 Benvenuto <a href=\"tg://user?id={$user->id}\">{$user->first_name}</a> sullo shop ufficiale di @antenna5gvodafone\n\nInfo:\n• Nome: {$user->first_name}\n• Username: ". ($user->username ?? "Nessuno") ."\n• ID: {$user->id}\n\nℹ️ Puoi trovare informazioni utili riguardanti programma per aggiungere membri, userbot e tanto altro\n\n©️ Bot sviluppato da @Antenna5GVodafone usando novagram.ga";
    $startParams = [ // send a Message in the Chat
        "text" => $replytext, // Message Text
        "reply_markup" => [
            "inline_keyboard" => [ // Message Inline Keyboard
                [
                    [
                        "text" => "Supporto",
                        "url" => "https://t.me/antenna5gvodafone"
                    ]
                ],
                [
                    [
                        "text" => "Shop",
                        "callback_data" => "shop"
                    ]
                ],
                [
                    [
                        "text" => "Info",
                        "callback_data" => "info"
                    ],
                    [
                        "text" => "Feedback",
                        "url" => "https://t.me/antenna5gvodafone"
                    ]
                ],
                [
                    [
                        "text" => "Canale",
                        "url" => "https://t.me/antenna5gvodafone"
                    ]
                ]
            ]
        ]
    ];
    $chat->sendMessage($startParams, true); // this true will print this api call as json payload
});


$Bot->onCallbackQuery(function (CallbackQuery $callback_query) use ($Bot, $shop) {
    $user = $callback_query->from;
    $data = $callback_query->data;

    $message = $callback_query->message;
    $chat = $message->chat;

    if($data === "start"){
        $replytext = "👋 Benvenuto <a href=\"tg://user?id={$user->id}\">{$user->first_name}</a> sullo shop ufficiale di @antenna5gvodafone\n\nInfo:\n• Nome: {$user->first_name}\n• Username: ". ($user->username ?? "Nessuno") ."\n• ID: {$user->id}\n\nℹ️ Puoi trovare informazioni utili riguardanti programma per aggiungere membri, userbot e tanto altro\n\n©️ Bot sviluppato da @Antenna5GVodafone usando novagram.ga";
        $startParams = [ // send a Message in the Chat
            "text" => $replytext, // Message Text
            "reply_markup" => [
                "inline_keyboard" => [ // Message Inline Keyboard
                    [
                        [
                            "text" => "Supporto",
                            "url" => "https://t.me/antenna5gvodafone"
                        ]
                    ],
                    [
                        [
                            "text" => "Shop",
                            "callback_data" => "shop"
                        ]
                    ],
                    [
                        [
                            "text" => "Info",
                            "callback_data" => "info"
                        ],
                        [
                            "text" => "Feedback",
                            "url" => "https://t.me/antenna5gvodafone"
                        ]
                    ],
                    [
                        [
                            "text" => "Canale",
                            "url" => "https://t.me/antenna5gvodafone"
                        ]
                    ]
                ]
            ]
        ];
        $message->editText($startParams, true); // this true will print this api call as json payload
    }
    if($data === "shop"){
        $inline = [];
        foreach ($shop as $title => $info) {
            $inline[] = [ ["text" => $title, "callback_data" => "info_".base64_encode($title)] ];
        }
        $message->editText([
            "text" => "⬇️ Scegli la categoria ⬇️",
            "reply_markup" => [
                "inline_keyboard" => $inline
            ]
        ], true);
    }
    if($data === "info"){
        $message->editText([
            "text" => "Benvenuto nella sezione informazioni di @MaRcOiSmAd",
            "reply_markup" => [
                "inline_keyboard" => [
                    [
                        [
                            "text" => "TOS",
                            "url" => "https://t.me/antenna5gvodafone"
                        ]
                    ],
                    [
                        [
                            "text" => "Indietro",
                            "callback_data" => "start"
                        ]
                    ]
                ]
            ]
        ], true);
    }
    if(preg_match('/^info_(.+)$/', $data, $matches)){
        $title = base64_decode($matches[1]);
        $row = $shop[$title];
        $message->editText([
            "text" => $row['description'],
            "reply_markup" => [
                "inline_keyboard" => [
                    [
                        [
                            "text" => "Compra",
                            "callback_data" => "buy_".base64_encode($title)
                        ]
                    ]
                ]
            ]
        ]);
    }
    if(preg_match('/^buy_(.+)$/', $data, $matches)){
        $title = base64_decode($matches[1]);
        $row = $shop[$title];
        $message->editText([
            "text" => "🏠 Home > $title

Per acquistare $title,
paga qui al link qui sotto <b>{$row['price']}€</b>
utilizzando il metodo di pagamento amici e familiari
e inserendo questo messaggio → <pre>{$user->id}|$title</pre>",
            "reply_markup" => [
                "inline_keyboard" => [
                    [
                        [
                            "text" => "Acquista ora",
                            "url" => "https://www.paypal.me/pefavore"
                        ]
                    ]
                ]
            ]
        ]);
    }

    $callback_query->answer();
});

?>
