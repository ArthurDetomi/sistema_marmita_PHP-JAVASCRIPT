class PurchaseController{
    constructor()
    {
        this._valueTotal = document.getElementById("soma-total");
        this._valueReceived = document.getElementById("vlrecebido");
        this._valueThing = document.getElementById("troco");
        this._formVenda = document.getElementById("form-cadastro-venda");
        


        this._disableButton = true; //para desabilitar botão de cadastrar venda
        this._lastButton = 0;
        this._listIDProducts = [];
        this.chargeSession(); //carrega a sessão
        this.initialize(); 
    }

    initialize()
    {
        this.initButtonsEvents();
        this.activeButtonSubmit(false); //verifica se tem que ativar o botão
    }
    //metodos get
    get disableButton()
    {
        return this._disableButton;
    }

    get formVenda()
    {
        return this._formVenda;
    }

    get lastButton()
    {
        return this._lastButton;
    }

    get valueTotal() 
    {
        return Utils.formatToFloat(this._valueTotal.innerHTML);
    }

    get valueReceived() //valor recebido
    {
        return Utils.formatToFloat(this._valueReceived.value);
    }

    get valueThing() //valorTroco
    {
        return Utils.formatToFloat(this._valueThing.innerHTML);
    }
    //metodos set
    set disableButton(value)
    {
        this._disableButton = value;
    }

    set formVenda(value)
    {
        this._formVenda = value;
    }

    set lastButton(value)
    {   
        this._lastButton = value;
    }


    set valueTotal(value = 0)
    {
        this._valueTotal.innerHTML = value;
    }

    set valueReceived(value = 0)
    {
        this._valueReceived.value = value;
    }

    set valueThing(value = 0)
    {
        this._valueThing.innerHTML = value;
    }
    //metodos em geral
    initButtonsEvents() //iniciar eventos dos botões
    {

        let buttons = document.querySelectorAll("#area-produtos > .produto [type=button]");
        buttons.forEach((btn, index)=>{
            this.addEventListenerAll(btn,"click drag", e=>{
                this.execButton(btn.id);
            });

            this.addEventListenerAll(btn, "mouseover mouseup mousedown",e=>{
                btn.style.cursor = "pointer";
            })
        });

        //iniciar botão do troco
        let buttonThing = document.querySelector("#botao-troco");
        buttonThing.addEventListener("click",event=>{

            buttonThing.classList.toggle("active");
            this.calcThing(); //calcular troco

        });
        
        //ativar formas de pagamento
        let activebutton = document.querySelectorAll("#forma-pagamentos .botoes-pagamento li > button"); 
        activebutton.forEach((btn, index)=>{
            btn.addEventListener("click", event=>{

                btn.classList.add("active");
                this.setPaymentMethodSession(btn.id);//manda para sessão a forma de pagamento
                this.disableButton = false;
                this.activeButtonSubmit(false); //ativa o botão submit
                this.insertPaymentForm(btn.innerHTML);//manda para o formulario para enviar via post
                if(this.lastButton == 0){
                    this.lastButton = btn.id;
                }
                if(btn.id != this.lastButton){ 
                    this.removeLast(this.lastButton);
                    this.lastButton = btn.id;
                }

            });

            this.addEventListenerAll(btn,"mouseover mouseup mousedown", event=>{
                btn.style.cursor = "pointer";
            });
        }); 

        this.setOptionButtonPerso(); //ativar botão do desconto e personalizações
    }

    activeButtonSubmit(desativar = true) //ativa o botão submit para cadastrar venda
    {
        //configurando botão submit -->
        let buttonSubmit = document.getElementById("cadastrar-venda");

        if(desativar == true || this.valueTotal <= 0 || this.disableButton){
             
            buttonSubmit.classList.add("disabled");
            buttonSubmit.disabled = true;
 
        }else{
 
            buttonSubmit.classList.remove("disabled");
            buttonSubmit.disabled = false;

        }
 
        buttonSubmit.addEventListener("click", event=>{

            sessionStorage.clear(); //limpa a sessão após cadastrar

        });
        //--->
    }

    execButton(btn) //executar botão + e -
    {
        let op = this.returnOP(btn);
        let id = this.returnID(btn);


        this.alterQuant(op, id);
    }

    alterQuant(op, id) //alternar quantidade de acordo com a opção escolhida
    {
        let qtd = document.querySelectorAll("#area-produtos > .produto [type=number]");
        if(op ==  "plus"){
    
            qtd.forEach(qtd =>{
                let qtdID = this.returnID(qtd.id);
                let cont = qtd.value;
                if(qtdID == id){
                    cont++;
                    qtd.value = cont;
                    this.calcValueTotal(id);
                    this.addListProducts(id, qtd.value);
                }

            });
            

        }else if(op == "minus"){

            qtd.forEach(qtd =>{
                let qtdID = this.returnID(qtd.id);
                if(qtd.value > 0){

                    let cont = qtd.value;
                    if(qtdID == id){
                        cont--;
                        qtd.value = cont;
                        this.calcValueTotal(id, false);
                        this.addListProducts(id, qtd.value);
                    }
                }
            });
            
            
        }
    }

    calcValueTotal(id, sum = true){ //Calcular valor total atual
        let price = document.querySelector(`#price-${id}`);

        if(sum){
            
            let soma = Utils.formatToFloat(this.valueTotal) + Utils.formatToFloat(price.innerHTML);
            this.valueTotal = Utils.formatPrice(soma);  
            
        }else{

            let subtracao = Utils.formatToFloat(this.valueTotal) - Utils.formatToFloat(price.innerHTML);
            this.valueTotal = Utils.formatPrice(subtracao);  

        }

        this.activeButtonSubmit(false); //verifica se ativa ou não o botão de cadastrar venda
    }

    calcThing()//calcular troco thing = troco
    {
        if(this.valueReceived != null && this.valueTotal != null && this.valueTotal != 0){
            this.valueThing = Utils.formatPrice(this.valueReceived - this.valueTotal);
        }
        if(!this.valueThing) Utils.formatPrice(this.valueThing = 0.00);
    }

    returnID(valueStr) //retornar o id
    {
        let id = valueStr.substr(valueStr.length - 1);
        return id;
    }

    returnOP(valueStr) //returnar a opção
    {
        let op = valueStr.substr(0, valueStr.indexOf("-"));
        return op;
    }
    
    addEventListenerAll(element, events, fn) //adicionar varios eventos separando por espaço
    {
        events.split(" ").forEach(event=>{
            element.addEventListener(event, fn, false);
        });
    }

    removeLast(id) //remover do último botão a classse active
    {
        let last = document.getElementById(id);
        last.classList.remove("active");
    }
    //Inicio Metodos de Sessão ------------------------------------>
    addListProducts(id, qtd) //adiciona ao array para enviar para sessão
    {
        if(this._listIDProducts.length > 0){
            let existe = false;
            for(let i = 0; i < this._listIDProducts.length; i++){

                if(this._listIDProducts[i].idproduct == id){ //verifica e se substitui

                    this._listIDProducts[i].quantidade = qtd;
                    existe = true;

                }
            }
            if(!existe) this._listIDProducts.push({"idproduct":id,"quantidade":qtd});

        }else{

            this._listIDProducts.push({"idproduct":id,"quantidade":qtd});

        }
        
        this.insertForSession();
        
    }

    insertForSession() //inseri na sessão os dados de produto
    {
        let dataProducts = [];
        
        if(sessionStorage.getItem("products")){
            
            let json = JSON.parse(sessionStorage.getItem("products"));

        }
        dataProducts.push(this._listIDProducts); 

        sessionStorage.setItem("products", JSON.stringify(dataProducts));

        this.createInput(JSON.stringify(this._listIDProducts)); //para enviar o JSON via formulário
    }

    createInput(json) //cria input para enviar para o php via Post, envia o json de produtos
    {

        if(document.querySelector(".none")){
            this.formVenda.removeChild(document.body.querySelector(".none"));
        } 
        let input = document.createElement("input");
        input.value = `
            ${json}
        `;
        input.classList.add("none");
        input.setAttribute("name","json");
        this.formVenda.appendChild(input);

    }

    insertPaymentForm(name) //inseri a  forma de pagamento no formulario para enviar via post
    {

        if(document.querySelector("#temp-payment")){
            this.formVenda.removeChild(document.body.querySelector("#temp-payment"));
        } 
        let input = document.createElement("input");
        input.value = `
            ${name}
        `;
        input.classList.add("none");
        input.setAttribute("id","temp-payment");
        input.setAttribute("name","payment");
        this.formVenda.appendChild(input);

    }

    chargeSession()//carregar sessão
    {
        if(sessionStorage.getItem("products")){

            let dataProducts = JSON.parse(sessionStorage.getItem("products"));
    
            let qtd = document.querySelectorAll("#area-produtos > .produto [type=number]");

            dataProducts = dataProducts[0];
            
            qtd.forEach(qtd=>{

                for(let i = 0; i < dataProducts.length; i++){

                    if(dataProducts[i].idproduct){

                        this.addListProducts(dataProducts[i].idproduct, dataProducts[i].quantidade);

                    }
                }   
                
                for(let i = 0; i < dataProducts.length; i++){

                    if(this.returnID(qtd.id) == dataProducts[i].idproduct){

                        qtd.value = dataProducts[i].quantidade;
                        this.setCalcValueTotalSession(this.returnID(qtd.id), dataProducts[i].quantidade);

                    }
                }   

            });
        }

        if(sessionStorage.getItem("paymentMethod")){

            let buttonPayment = document.getElementById(sessionStorage.getItem("paymentMethod"));
            buttonPayment.classList.add("active");
            this.setPaymentMethodSession(buttonPayment.id);
            this.activeButtonSubmit(false); //ativa o botão submit
            this.insertPaymentForm(buttonPayment.innerHTML); //manda para sessão a forma de pagamento
            if(this.lastButton == 0){

                this.lastButton = buttonPayment.id;
                
            }
            if(buttonPayment.id != this.lastButton){ 

                this.removeLast(this.lastButton);
                this.lastButton = buttonPayment.id;

            }

        }
    }

    setCalcValueTotalSession(id, qtd) //calcular valor total da sessão
    {
        let price = document.querySelector(`#price-${id}`);

        let operation = Utils.formatToFloat(qtd) * Utils.formatToFloat(price.innerHTML);

        if(this.valueTotal > 0) operation = Utils.formatToFloat(operation) + Utils.formatToFloat(this.valueTotal);

        this.valueTotal = Utils.formatPrice(operation);  
            
    }

    setPaymentMethodSession($paymentMethod) //seta o modo de pagamento salvo na sessão
    {
        if(sessionStorage.getItem("paymentMethod")){

            sessionStorage.removeItem("paymentMethod");

        }

        sessionStorage.setItem("paymentMethod", $paymentMethod);
    }
    //fim metodos de sessão -------------------->

    //metodos de desconto, valores persnalidos -------------------------------------------------
   
    setOptionButtonPerso()
    {
        let buttonPerso = document.querySelector("#button-perso");
        let valuePerso = document.querySelector("#value-perso");
        let options = document.querySelectorAll("#opcoes-perso > li a"); 
        let aplicar = document.querySelector("#aplicar-alteracoes");
        let newValuePerso = document.querySelector("#novo-valor-perso")


        let textaux = 'Personalizar Preço<span class="caret"></span>'; //texto auxiliar para verificar condição, se a pessoa escolher personalizar o valor

        options.forEach(opt=>{
            opt.addEventListener("click",event=>{
                
                let aux = buttonPerso.innerHTML;
                buttonPerso.innerHTML = opt.innerHTML;
                opt.innerHTML = aux;
                if(buttonPerso.innerHTML == textaux){

                    valuePerso.placeholder = "R$";
                    valuePerso.value = "";
                    newValuePerso.value = "";

                }else{

                    valuePerso.placeholder = "%";
                    valuePerso.value = "";
                    newValuePerso.value = "";

                }

            });
        });

        aplicar.addEventListener("click", event=>{

            if(buttonPerso.innerHTML == textaux){ //personalizar preço

                if(valuePerso.value != "" && Utils.formatToFloat(valuePerso.value) > 0){

                    newValuePerso.value = valuePerso.value;
                    this.addValuePersoToForm(Utils.formatToFloat(newValuePerso.value));//adicionar novo valor para mandar via php atraves do formulario

                }else{

                    this.addValuePersoToForm(0, true); //exclui o elemento se existir

                }

            }else{

                if(valuePerso.value != ""){ //dar desconto

                    let desconto = (100 - Utils.formatToFloat(valuePerso.value)) / 100;

                    if(Utils.formatToFloat(this.valueTotal) > 0){

                        newValuePerso.value = Utils.formatToFloat(this.valueTotal) * desconto;
                        this.addValuePersoToForm(newValuePerso.value);//adicionar novo valor para mandar via php atraves do formulario
                    
                    }else{

                        this.addValuePersoToForm(0, true); //excluir o elemento se existir

                    }

                }

            }
        });

    }

    addValuePersoToForm(value, deleteEl = false) //inseri a  forma de pagamento no formulario para enviar via post
    {
        if(!deleteEl){
            if(document.querySelector("#temp-perso")){

                this.formVenda.removeChild(document.body.querySelector("#temp-perso"));

            } 
            let input = document.createElement("input");
            input.value = `
                ${Utils.formatToFloat(value)}
            `;
            input.classList.add("none");
            input.setAttribute("id","temp-perso");
            input.setAttribute("name","value-total-perso");
            this.formVenda.appendChild(input);
        }else {

            if(document.querySelector("#temp-perso")){

                this.formVenda.removeChild(document.body.querySelector("#temp-perso"));

            } 

        }
        

    }
    //---------------------------------------------------------------------------------------->

}