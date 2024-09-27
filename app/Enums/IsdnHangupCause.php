<?php

namespace App\Enums;

enum IsdnHangupCause: int
{
    case AST_CAUSE_UNALLOCATED = 1; // 1. Número não alocado (não atribuído)
    case AST_CAUSE_NO_ROUTE_TRANSIT_NET = 2; // 2. Sem rota para a rede de transmissão especificada
    case AST_CAUSE_NO_ROUTE_DESTINATION = 3; // 3. Sem rota para o destino
    case AST_CAUSE_MISDIALLED_TRUNK_PREFIX = 5; // 5. Prefixo de tronco discado incorretamente (uso nacional)
    case AST_CAUSE_CHANNEL_UNACCEPTABLE = 6; // 6. Canal inaceitável
    case AST_CAUSE_CALL_AWARDED_DELIVERED = 7; // 7. Chamada concedida e sendo entregue em um canal estabelecido
    case AST_CAUSE_PRE_EMPTED_ISUP = 8; // 8. Preempção
    case AST_CAUSE_NUMBER_PORTED_NOT_HERE = 14; // 14. QoR: número portado
    case AST_CAUSE_NORMAL_CLEARING = 16; // 16. Desligamento normal
    case AST_CAUSE_USER_BUSY = 17; // 17. Usuário ocupado
    case AST_CAUSE_NO_USER_RESPONSE = 18; // 18. Nenhuma resposta do usuário
    case AST_CAUSE_NO_ANSWER = 19; // 19. Nenhuma resposta do usuário (usuário alertado)
    case AST_CAUSE_SUBSCRIBER_ABSENT = 20; // 20. Assinante ausente
    case AST_CAUSE_CALL_REJECTED = 21; // 21. Chamada rejeitada
    case AST_CAUSE_NUMBER_CHANGED = 22; // 22. Número alterado
    case AST_CAUSE_REDIRECTED_TO_NEW_DESTINATION = 23; // 23. Redirecionado para novo destino
    case AST_CAUSE_ANSWERED_ELSEWHERE = 26; // 26. Desligamento de usuário não selecionado (ASTERISK-15057)
    case AST_CAUSE_DESTINATION_OUT_OF_ORDER = 27; // 27. Destino fora de serviço
    case AST_CAUSE_INVALID_NUMBER_FORMAT = 28; // 28. Formato de número inválido
    case AST_CAUSE_FACILITY_REJECTED = 29; // 29. Instalação rejeitada
    case AST_CAUSE_RESPONSE_TO_STATUS_ENQUIRY = 30; // 30. Resposta a consulta de status
    case AST_CAUSE_NORMAL_UNSPECIFIED = 31; // 31. Normal, não especificado
    case AST_CAUSE_NORMAL_CIRCUIT_CONGESTION = 34; // 34. Nenhum circuito/canal disponível (este código tem causado confusão com o código 42)
    case AST_CAUSE_NETWORK_OUT_OF_ORDER = 38; // 38. Rede fora de serviço
    case AST_CAUSE_NORMAL_TEMPORARY_FAILURE = 41; // 41. Falha temporária
    case AST_CAUSE_SWITCH_CONGESTION = 42; // 42. Congestionamento do equipamento de comutação
    case AST_CAUSE_ACCESS_INFO_DISCARDED = 43; // 43. Informação de acesso descartada
    case AST_CAUSE_REQUESTED_CHAN_UNAVAIL = 44; // 44. Circuito/canal solicitado não disponível
    case AST_CAUSE_FACILITY_NOT_SUBSCRIBED = 50; // 50. Instalação solicitada não assinada
    case AST_CAUSE_OUTGOING_CALL_BARRED = 52; // 52. Chamada de saída barrada
    case AST_CAUSE_INCOMING_CALL_BARRED = 54; // 54. Chamada de entrada barrada
    case AST_CAUSE_BEARERCAPABILITY_NOTAUTH = 57; // 57. Capacidade de portadora não autorizada
    case AST_CAUSE_BEARERCAPABILITY_NOTAVAIL = 58; // 58. Capacidade de portadora não disponível no momento
    case AST_CAUSE_BEARERCAPABILITY_NOTIMPL = 65; // 65. Capacidade de portadora não implementada
    case AST_CAUSE_CHAN_NOT_IMPLEMENTED = 66; // 66. Tipo de canal não implementado
    case AST_CAUSE_FACILITY_NOT_IMPLEMENTED = 69; // 69. Instalação solicitada não implementada
    case AST_CAUSE_INVALID_CALL_REFERENCE = 81; // 81. Valor de referência de chamada inválido
    case AST_CAUSE_INCOMPATIBLE_DESTINATION = 88; // 88. Destino incompatível
    case AST_CAUSE_INVALID_MSG_UNSPECIFIED = 95; // 95. Mensagem inválida não especificada
    case AST_CAUSE_MANDATORY_IE_MISSING = 96; // 96. Elemento de informação obrigatório ausente
    case AST_CAUSE_MESSAGE_TYPE_NONEXIST = 97; // 97. Tipo de mensagem não existente ou não implementado
    case AST_CAUSE_WRONG_MESSAGE = 98; // 98. Mensagem não compatível com o estado da chamada ou tipo de mensagem não existente ou não implementado
    case AST_CAUSE_IE_NONEXIST = 99; // 99. Elemento de informação inexistente ou não implementado
    case AST_CAUSE_INVALID_IE_CONTENTS = 100; // 100. Conteúdo de elemento de informação inválido
    case AST_CAUSE_WRONG_CALL_STATE = 101; // 101. Mensagem não compatível com o estado da chamada
    case AST_CAUSE_RECOVERY_ON_TIMER_EXPIRE = 102; // 102. Recuperação na expiração do timer
    case AST_CAUSE_PROTOCOL_ERROR = 111; // 111. Erro de protocolo, não especificado
    case AST_CAUSE_INTERWORKING = 127; // 127. Interconexão, não especificada

    public function getCauseDescription(): string
    {
        return match ($this) {
            self::AST_CAUSE_UNALLOCATED => 'Número não alocado (não atribuído)',
            self::AST_CAUSE_NO_ROUTE_TRANSIT_NET => 'Sem rota para a rede de transmissão especificada',
            self::AST_CAUSE_NO_ROUTE_DESTINATION => 'Sem rota para o destino',
            self::AST_CAUSE_MISDIALLED_TRUNK_PREFIX => 'Prefixo de tronco discado incorretamente (uso nacional)',
            self::AST_CAUSE_CHANNEL_UNACCEPTABLE => 'Canal inaceitável',
            self::AST_CAUSE_CALL_AWARDED_DELIVERED => 'Chamada concedida e sendo entregue em um canal estabelecido',
            self::AST_CAUSE_PRE_EMPTED_ISUP => 'Preempção',
            self::AST_CAUSE_NUMBER_PORTED_NOT_HERE => 'QoR: número portado',
            self::AST_CAUSE_NORMAL_CLEARING => 'Desligamento normal',
            self::AST_CAUSE_USER_BUSY => 'Usuário ocupado',
            self::AST_CAUSE_NO_USER_RESPONSE => 'Nenhuma resposta do usuário',
            self::AST_CAUSE_NO_ANSWER => 'Nenhuma resposta do usuário (usuário alertado)',
            self::AST_CAUSE_SUBSCRIBER_ABSENT => 'Assinante ausente',
            self::AST_CAUSE_CALL_REJECTED => 'Chamada rejeitada',
            self::AST_CAUSE_NUMBER_CHANGED => 'Número alterado',
            self::AST_CAUSE_REDIRECTED_TO_NEW_DESTINATION => 'Redirecionado para novo destino',
            self::AST_CAUSE_ANSWERED_ELSEWHERE => 'Desligamento de usuário não selecionado (ASTERISK-15057)',
            self::AST_CAUSE_DESTINATION_OUT_OF_ORDER => 'Destino fora de serviço',
            self::AST_CAUSE_INVALID_NUMBER_FORMAT => 'Formato de número inválido',
            self::AST_CAUSE_FACILITY_REJECTED => 'Instalação rejeitada',
            self::AST_CAUSE_RESPONSE_TO_STATUS_ENQUIRY => 'Resposta a consulta de status',
            self::AST_CAUSE_NORMAL_UNSPECIFIED => 'Normal, não especificado',
            self::AST_CAUSE_NORMAL_CIRCUIT_CONGESTION => 'Nenhum circuito/canal disponível',
            self::AST_CAUSE_NETWORK_OUT_OF_ORDER => 'Rede fora de serviço',
            self::AST_CAUSE_NORMAL_TEMPORARY_FAILURE => 'Falha temporária',
            self::AST_CAUSE_SWITCH_CONGESTION => 'Congestionamento do equipamento de comutação',
            self::AST_CAUSE_ACCESS_INFO_DISCARDED => 'Informação de acesso descartada',
            self::AST_CAUSE_REQUESTED_CHAN_UNAVAIL => 'Circuito/canal solicitado não disponível',
            self::AST_CAUSE_FACILITY_NOT_SUBSCRIBED => 'Instalação solicitada não assinada',
            self::AST_CAUSE_OUTGOING_CALL_BARRED => 'Chamada de saída barrada',
            self::AST_CAUSE_INCOMING_CALL_BARRED => 'Chamada de entrada barrada',
            self::AST_CAUSE_BEARERCAPABILITY_NOTAUTH => 'Capacidade de portadora não autorizada',
            self::AST_CAUSE_BEARERCAPABILITY_NOTAVAIL => 'Capacidade de portadora não disponível no momento',
            self::AST_CAUSE_BEARERCAPABILITY_NOTIMPL => 'Capacidade de portadora não implementada',
            self::AST_CAUSE_CHAN_NOT_IMPLEMENTED => 'Tipo de canal não implementado',
            self::AST_CAUSE_FACILITY_NOT_IMPLEMENTED => 'Instalação solicitada não implementada',
            self::AST_CAUSE_INVALID_CALL_REFERENCE => 'Valor de referência de chamada inválido',
            self::AST_CAUSE_INCOMPATIBLE_DESTINATION => 'Destino incompatível',
            self::AST_CAUSE_INVALID_MSG_UNSPECIFIED => 'Mensagem inválida não especificada',
            self::AST_CAUSE_MANDATORY_IE_MISSING => 'Elemento de informação obrigatório ausente',
            self::AST_CAUSE_MESSAGE_TYPE_NONEXIST => 'Tipo de mensagem não existente ou não implementado',
            self::AST_CAUSE_WRONG_MESSAGE => 'Mensagem não compatível com o estado da chamada',
            self::AST_CAUSE_IE_NONEXIST => 'Elemento de informação inexistente ou não implementado',
            self::AST_CAUSE_INVALID_IE_CONTENTS => 'Conteúdo de elemento de informação inválido',
            self::AST_CAUSE_WRONG_CALL_STATE => 'Mensagem não compatível com o estado da chamada',
            self::AST_CAUSE_RECOVERY_ON_TIMER_EXPIRE => 'Recuperação na expiração do timer',
            self::AST_CAUSE_PROTOCOL_ERROR => 'Erro de protocolo, não especificado',
            self::AST_CAUSE_INTERWORKING => 'Interconexão, não especificada',
        };
    }
}
