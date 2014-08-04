<?php

return array(
//
    'recordFound' => "Foi encontrado um registro '%value%'.",
    'noRecordFound' => "N�o foi encontrado nenhum registro '%value%'.",
//String
    'isEmpty' => 'Este campo n�o pode ser vazio.',
    'stringEmpty' => "'%value%' � uma string vazia.",
//Email
    'emailAddressInvalidFormat' => 'Por favor, forne�a um e-mail v�lido no formato nome@servidor',
    'emailAddressInvalidHostname' => 'Por favor, forne�a um e-mail v�lido no formato nome@servidor',
    'emailAddressInvalidMxRecord' => 'Por favor, forne�a um e-mail v�lido no formato nome@servidor',
    'emailAddressInvalidSegment' => 'Por favor, forne�a um e-mail v�lido no formato nome@servidor',
    'emailAddressDotAtom' => 'Por favor, forne�a um e-mail v�lido no formato nome@servidor',
    'emailAddressQuotedString' => 'Por favor, forne�a um e-mail v�lido no formato nome@servidor',
    'emailAddressInvalidLocalPart' => 'Por favor, forne�a um e-mail v�lido no formato nome@servidor',
    'emailAddressLengthExceeded' => 'Por favor, forne�a um e-mail v�lido no formato nome@servidor',
    'emailAddressInvalidFormat' => 'Por favor, forne�a um e-mail v�lido no formato nome@servidor',
    'emailAddressInvalid' => 'N�o � um email v�lido no formato nome@servidor.',
//hostname
    'hostnameIpAddressNotAllowed' => "'%value%' Parece ser um endere�o de IP, mas endere�os de IP n�o s�o permitidos.",
    'hostnameUnknownTld' => "'%value%' parece ser um DNS, mas n�o foi possivel validar o TLD.",
    'hostnameDashCharacter' => "'%value%' parece ser um DNS, mas cont�m um 'dash' (-) em uma posi��o inv�lida.",
    'hostnameInvalidHostnameSchema' => "'%value%' parece ser um DNS, mas n�o foi poss�vel comparar com o schema para o TLD '%tld%'.",
    'hostnameUndecipherableTld' => "'%value%' parece ser um DNS mas n�o foi poss�vel extrair o TLD.",
    'hostnameInvalidHostname' => "'%value% n�o � compat�vel com a estrutura DNS.",
    'hostnameInvalidLocalName' => "'%value%' n�o parece ser uma rede local v�lida.",
    'hostnameLocalNameNotAllowed' => "'%value%' parece ser o nome de uma rede local, mas nome de rede local n�o s�o permitido.",
//identical
    'notSame' => "Compara��o n�o bate",
    'missingToken' => "N�o foi fornecido par�metros para teste.",
//greater then
    'notGreaterThan' => "'%value%' n�o � maior que '%min%'.",
//float
    'notFloat' => "'%value%' n�o � do tipo float.",
//date
    'dateNotYYYY-MM-DD' => "'%value%' deve estar no formato aaaa-mm-dd.",
    'dateInvalid' => "'%value%' n�o parece ser um data v�lida.",
//    'dateFalseFormat' => "'%value%' n�o combina com o formato informado.",
    'dateFalseFormat' => "'%value%' n�o parece ser um data v�lida.",
    'dateInvalidDate' => "'%value%' n�o parece ser um data v�lida.",
//digits
    'notDigits' => "'%value%' n�o cont�m apenas d�gitos.",
//between
    'notBetween' => "'%value%' n�o est� entre '%min%' e '%max%', inclusive.",
    'notBetweenStrict' => "'%value%' n�o est� estritamente entre '%min%' e '%max%'.",
//alnum
    'notAlnum' => "'%value%' n�o possu� apenas letras e d�gitos.",
//alpha
    'notAlpha' => "'%value%' n�o possu� apenas letras.",
//in array
    'notInArray' => "'%value%' n�o foi encontrado na lista.",
//int
//    'notInt' => "'%value%' n�o parece ser um inteiro.",
    'notInt' => "Precisa ser um n�mero inteiro!",
//ip
    'notIpAddress' => "'%value%' n�o parece ser um endere�o ip v�lido.",
//lessthan
    'notLessThan' => "'%value%' n�o � menor que '%max%'.",
//notempty
    'isEmpty' => "Campo vazio!",
//regex
    'regexNotMatch' => "'%value%' n�o foi validado na express�o '%pattern%'.",
//stringlength
    'stringLengthTooShort' => "'%value%' � menor que %min% (tamanho m�nimo desse campo).",
    'stringLengthTooLong' => "Campo maior que o limite de caracteres permitidos (%max%).",
//file
    'fileUploadErrorIniSize' => "O arquivo excede o tamanho m�ximo permitido (ini).",
    'fileUploadErrorFormSize' => "O arquivo excede o tamanho m�ximo permitido.",
    'fileUploadErrorPartial' => "O arquivo '%value%' foi enviado 'parcialmente'.",
    'fileUploadErrorNoFile' => "O arquivo n�o foi enviado.",
    'fileUploadErrorNoTmpDir' => "Nenhum diret�rio tempor�rio foi setado para o arquivo '%value%'.",
    'fileUploadErrorCantWrite' => "O arquivo '%value%' n�o pode ser gravado.",
    'fileUploadErrorExtension' => "A extens�o retornou um erro enquanto enviava o arquivo: '%value%'.",
    'fileUploadErrorAttack' => "O arquivo '%value%' � um upload ilegal, possivelmente um ataque.",
    'fileUploadErrorFileNotFound' => "O arquivo '%value%' n�o foi encontrado.",
    'fileUploadErrorUnknown' => "Ocorreu um erro desconhecido ao enviar o arquivo: '%value%'.",
//file->mimetype
    'fileMimeTypeFalse' => "O arquivo '%value%' n�o foi enviado por ser de um tipo n�o permitido.",
    'fileMimeTypeNotDetected' => "N�o pode ser detectado o tipo do arquivo: '%value%'.",
    'fileMimeTypeNotReadable' => "O Arquivo '%value%' n�o pode ser lido.",
//file->filesize
    'fileSizeTooBig' => "O tamanho m�ximo do arquivo '%value%' deve ser de '%max%', por�m o arquivo enviado possui '%size%'.",
    'fileFilesSizeTooBig' => "O tamanho m�ximo do arquivo deve ser de:'%max%', por�m o arquivo enviado possui: '%size%'.",
    'fileFilesSizeTooSmall' => "O tamanho m�nimo do arquivo deve ser de:'%min%', por�m o arquivo enviado possui: '%size%'.",
    'fileFilesSizeNotReadable' => "Um ou mais arquivos n�o puderam ser lidos.",
//file->excludeextension
    'fileExtensionFalse' => "O arquivo '%value%' possui uma extens�o n�o permitida.",
    'fileExcludeExtensionFalse' => "O arquivo '%value%' possui uma extens�o n�o permitida.",
    'fileExcludeExtensionNotFound' => "O arquivo '%value%' n�o foi encontrado",
    'callbackValue' => "O valor '%value%' n�o � v�lido!"
);
