<?php

namespace App;

use App\Entity\Client;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class ClientNormalizer implements ContextAwareNormalizerInterface
{
    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof Client && key_exists("normalize", $context);
    }

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        if (method_exists($this, $context['normalize'])) {
            $normalize = $context['normalize'];
            return $this->$normalize($object, $format, $context);
        }
        return null;
    }

    public
    function normalizeClient(Client $object, string $format = null, array $context = [])
    {
        $application = $object->getApplications()->last();
        return [
            "constraction" => [
                "infoForLead" => [
                    [
                        "label" => "Услуга",
                        "name" => $application->getService() ?? null
                    ],
                    [
                        "label" => "Источник",
                        "name" => $application->getSource() ?? null
                    ],
                    [
                        "label" => "Необходимое пространство",
                        "name" => $application->getSpace() ?? null
                    ],
                    [
                        "label" => "Назначение помещения",
                        "name" => $application->getRoom() ?? null
                    ],
                    [
                        "label" => "Тип помещения",
                        "name" => $application->getTypeRoom() ?? null
                    ]
                ],
                "infoForClient" => [
                    [
                        "Id Клиента" => $object->getId(),
                        "Фамилия" => $object->getLastname(),
                        "Имя" => $object->getFirstname(),
                        "Отчество" => $object->getPatronymic()
                    ],
                ],
                "anketClient" => [
                    ["type" => "text", "name" => "name", "label" => "Имя"],
                    ["type" => "number", "name" => "age", "label" => "Возраст", "min" => 0],
                    ["type" => "array",
                        "name" => "problem",
                        "label" => "Проблемы",
                        "item" => [
                            ["type" => "checkbox", "label" => "Нету денег", "name" => "notMany"],
                            ["type" => "checkbox", "label" => "Не слышал о бренде", "name" => "unknowBrend"],
                            ["type" => "checkbox", "label" => "Думает", "name" => "thinks"],
                            ["type" => "checkbox", "label" => "Жена против", "name" => "fingerFack"]
                        ]
                    ],
                    [
                        "type" => "selector",
                        "name" => "select",
                        "label" => "Выбор продукта",
                        "options" => [
                            ["label" => "Первый пункт", "value" => "one"],
                            ["label" => "Второй пункт", "value" => "two"],
                            ["label" => "Третий пункт", "value" => "three"]
                        ]
                    ],
                    ["type" => "text", "name" => "name", "label" => "Имя"],
                    ["type" => "number", "name" => "age", "label" => "Возраст", "min" => 0],
                    ["type" => "text", "name" => "name", "label" => "Имя"],
                    ["type" => "number", "name" => "age", "label" => "Возраст", "min" => 0],
                    ["type" => "text", "name" => "name", "label" => "Имя"],
                    ["type" => "number", "name" => "age", "label" => "Возраст", "min" => 0],
                    ["type" => "text", "name" => "name", "label" => "Имя"],
                    ["type" => "number", "name" => "age", "label" => "Возраст", "min" => 0]
                ],
                "dialog" => [
                    "1" => [
                        "dialog" => "Текст манагера",
                        "clientText" => "Текс лоха",
                        "answers" => [
                            "2" => "ответ2 grdoopgrt mhpfpompfombpomopsd mfopsmdfopmsdofmosdmfosmdpofop sfmosmfosmfm pofsmdopmfopsdmfosdmfpmdspofm msfopmposmfdpmsdfosdpofm",
                            "3" => "ответ3",
                            "4" => "ответ4",
                            "5" => "ответ5"
                        ]
                    ],
                    "2" => [
                        "dialog" => "Текст манагера 2",
                        "clientText" => "Текс лоха 2",
                        "answers" => [
                            "1" => "ответ1",
                            "3" => "ответ3",
                            "4" => "ответ4",
                            "5" => "ответ5"
                        ]
                    ],
                    "3" => [
                        "dialog" => "Текст манагера3",
                        "clientText" => "Текс лоха3",
                        "answers" => [
                            "1" => "ответ1",
                            "2" => "ответ2",
                            "4" => "ответ4",
                            "5" => "ответ5"
                        ]
                    ],
                    "4" => [
                        "dialog" => "Текст манагера4",
                        "clientText" => "Текс лоха4",
                        "answers" => [
                            "1" => "ответ1",
                            "2" => "ответ2",
                            "4" => "ответ4",
                            "5" => "ответ5"
                        ]
                    ],
                    "5" => [
                        "dialog" => "Текст манагера5",
                        "clientText" => "Текс лоха5",
                        "answers" => [
                            "1" => "ответ1",
                            "2" => "ответ2",
                            "3" => "ответ3",
                            "4" => "ответ4"
                        ]
                    ]
                ]
            ],
            "data" => [
                "name" => $object->getFirstname()
            ],
            "dialogHistory" => ["1"]

        ];
    }
}