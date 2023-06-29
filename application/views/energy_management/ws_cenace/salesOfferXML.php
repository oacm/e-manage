<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Header>
        <Authentication xmlns="http://xmlns.cenace.com/">
            <userNameToken>FENIX20163</userNameToken>
            <passwordToken>kiko2760+3</passwordToken>
            <hd>219c8156f1bfd1b7f538152aeae0ef5f8d3c048e</hd>
        </Authentication>
    </soap:Header>
    <soap:Body>
        <enviarOfertaNoDespachable xmlns="http://xmlns.cenace.com/">
            <clvParticipante>G002</clvParticipante>
            <fechaInicial><?php echo $dateStart;?></fechaInicial>
            <fechaFinal><?php echo $dateEnd;?></fechaFinal>
            <clvCentral><?php echo $placeCode; ?></clvCentral>
            <clvUnidad><?php echo $unitCode;?></clvUnidad>
            <clvSistema>SIN</clvSistema>
            <jsonOE>
                {"ofertaEconomica": <?php echo json_encode($energyJSON); ?>}
            </jsonOE>
        </enviarOfertaNoDespachable>
    </soap:Body>
</soap:Envelope>