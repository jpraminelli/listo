<?php

return array(
//
    'recordFound' => "Foi encontrado um registro '%value%'.",
    'noRecordFound' => "Não foi encontrado nenhum registro '%value%'.",
//String
    'isEmpty' => 'Este campo não pode ser vazio.',
    'stringEmpty' => "'%value%' é uma string vazia.",
//Email
    'emailAddressInvalidFormat' => 'Por favor, forneça um e-mail válido no formato nome@servidor',
    'emailAddressInvalidHostname' => 'Por favor, forneça um e-mail válido no formato nome@servidor',
    'emailAddressInvalidMxRecord' => 'Por favor, forneça um e-mail válido no formato nome@servidor',
    'emailAddressInvalidSegment' => 'Por favor, forneça um e-mail válido no formato nome@servidor',
    'emailAddressDotAtom' => 'Por favor, forneça um e-mail válido no formato nome@servidor',
    'emailAddressQuotedString' => 'Por favor, forneça um e-mail válido no formato nome@servidor',
    'emailAddressInvalidLocalPart' => 'Por favor, forneça um e-mail válido no formato nome@servidor',
    'emailAddressLengthExceeded' => 'Por favor, forneça um e-mail válido no formato nome@servidor',
    'emailAddressInvalidFormat' => 'Por favor, forneça um e-mail válido no formato nome@servidor',
    'emailAddressInvalid' => 'Não é um email válido no formato nome@servidor.',
//hostname
    'hostnameIpAddressNotAllowed' => "'%value%' Parece ser um endereço de IP, mas endereços de IP não são permitidos.",
    'hostnameUnknownTld' => "'%value%' parece ser um DNS, mas não foi possivel validar o TLD.",
    'hostnameDashCharacter' => "'%value%' parece ser um DNS, mas contém um 'dash' (-) em uma posição inválida.",
    'hostnameInvalidHostnameSchema' => "'%value%' parece ser um DNS, mas não foi possível comparar com o schema para o TLD '%tld%'.",
    'hostnameUndecipherableTld' => "'%value%' parece ser um DNS mas não foi possível extrair o TLD.",
    'hostnameInvalidHostname' => "'%value% não é compatível com a estrutura DNS.",
    'hostnameInvalidLocalName' => "'%value%' não parece ser uma rede local válida.",
    'hostnameLocalNameNotAllowed' => "'%value%' parece ser o nome de uma rede local, mas nome de rede local não são permitido.",
//identical
    'notSame' => "Comparação não bate",
    'missingToken' => "Não foi fornecido parâmetros para teste.",
//greater then
    'notGreaterThan' => "'%value%' não é maior que '%min%'.",
//float
    'notFloat' => "'%value%' não é do tipo float.",
//date
    'dateNotYYYY-MM-DD' => "'%value%' deve estar no formato aaaa-mm-dd.",
    'dateInvalid' => "'%value%' não parece ser um data válida.",
//    'dateFalseFormat' => "'%value%' não combina com o formato informado.",
    'dateFalseFormat' => "'%value%' não parece ser um data válida.",
    'dateInvalidDate' => "'%value%' não parece ser um data válida.",
//digits
    'notDigits' => "'%value%' não contém apenas dígitos.",
//between
    'notBetween' => "'%value%' não está entre '%min%' e '%max%', inclusive.",
    'notBetweenStrict' => "'%value%' não está estritamente entre '%min%' e '%max%'.",
//alnum
    'notAlnum' => "'%value%' não possuí apenas letras e dígitos.",
//alpha
    'notAlpha' => "'%value%' não possuí apenas letras.",
//in array
    'notInArray' => "'%value%' não foi encontrado na lista.",
//int
//    'notInt' => "'%value%' não parece ser um inteiro.",
    'notInt' => "Precisa ser um número inteiro!",
//ip
    'notIpAddress' => "'%value%' não parece ser um endereço ip válido.",
//lessthan
    'notLessThan' => "'%value%' não é menor que '%max%'.",
//notempty
    'isEmpty' => "Campo vazio!",
//regex
    'regexNotMatch' => "'%value%' não foi validado na expressão '%pattern%'.",
//stringlength
    'stringLengthTooShort' => "'%value%' é menor que %min% (tamanho mínimo desse campo).",
    'stringLengthTooLong' => "Campo maior que o limite de caracteres permitidos (%max%).",
//file
    'fileUploadErrorIniSize' => "O arquivo excede o tamanho máximo permitido (ini).",
    'fileUploadErrorFormSize' => "O arquivo excede o tamanho máximo permitido.",
    'fileUploadErrorPartial' => "O arquivo '%value%' foi enviado 'parcialmente'.",
    'fileUploadErrorNoFile' => "O arquivo não foi enviado.",
    'fileUploadErrorNoTmpDir' => "Nenhum diretório temporário foi setado para o arquivo '%value%'.",
    'fileUploadErrorCantWrite' => "O arquivo '%value%' não pode ser gravado.",
    'fileUploadErrorExtension' => "A extensão retornou um erro enquanto enviava o arquivo: '%value%'.",
    'fileUploadErrorAttack' => "O arquivo '%value%' é um upload ilegal, possivelmente um ataque.",
    'fileUploadErrorFileNotFound' => "O arquivo '%value%' não foi encontrado.",
    'fileUploadErrorUnknown' => "Ocorreu um erro desconhecido ao enviar o arquivo: '%value%'.",
//file->mimetype
    'fileMimeTypeFalse' => "O arquivo '%value%' não foi enviado por ser de um tipo não permitido.",
    'fileMimeTypeNotDetected' => "Não pode ser detectado o tipo do arquivo: '%value%'.",
    'fileMimeTypeNotReadable' => "O Arquivo '%value%' não pode ser lido.",
//file->filesize
    'fileSizeTooBig' => "O tamanho máximo do arquivo '%value%' deve ser de '%max%', porém o arquivo enviado possui '%size%'.",
    'fileFilesSizeTooBig' => "O tamanho máximo do arquivo deve ser de:'%max%', porém o arquivo enviado possui: '%size%'.",
    'fileFilesSizeTooSmall' => "O tamanho mínimo do arquivo deve ser de:'%min%', porém o arquivo enviado possui: '%size%'.",
    'fileFilesSizeNotReadable' => "Um ou mais arquivos não puderam ser lidos.",
//file->excludeextension
    'fileExtensionFalse' => "O arquivo '%value%' possui uma extensão não permitida.",
    'fileExcludeExtensionFalse' => "O arquivo '%value%' possui uma extensão não permitida.",
    'fileExcludeExtensionNotFound' => "O arquivo '%value%' não foi encontrado",
    'callbackValue' => "O valor '%value%' não é válido!"
);
