class PurchaseController{
    constructor()
    {
        this._valueTotal = document.getElementById("soma-total");
        this._valueReceived = document.getElementById("vlrecebido");
        this._valueThing = document.getElementById("troco");

        this._lastButton = 0;
        this._listIDProducts = [];
        this.initialize(); 
        this.chargeSession(); 
    }

    initialize()
    {
        this.initButtonsEvents();
    }
    //metodos get
    get lastButton()
    {
        return this._lastButton;
    }

    set lastButton(value)
    {   
        this._lastButton = value;
    }

    get valueTotal()
    {
        return Utils.formatToFloat(this._valueTotal.innerHTML);
    }

    get valueReceived()
    {
        return Utils.formatToFloat(this._valueReceived.value);
    }

    get valueThing()
    {
        return Utils.formatToFloat(this._valueThing.innerHTML);
    }
    //metodos set
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
    initButtonsEvents()
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

                btn.classList.add("active")
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

        //configurando botão submit
        let buttonSubmit = document.getElementById("cadastrar-venda");

        buttonSubmit.addEventListener("click", event=>{
            
        });

    }

    execButton(btn)
    {
        let op = this.returnOP(btn);
        let id = this.returnID(btn);


        this.alterQuant(op, id);
    }

    alterQuant(op, id)
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

            //window.location.href = "/sistemamarmita/plus";

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

            //window.location.href="/sistemamarmita/minus";
        }
    }

    calcValueTotal(id, sum = true){
        let price = document.querySelector(`#price-${id}`);

        if(sum){
            
            let soma = Utils.formatToFloat(this.valueTotal) + parseFloat(price.innerHTML);
            this.valueTotal = Utils.formatPrice(soma);  
            
        }else{

            let subtracao = Utils.formatToFloat(this.valueTotal) - parseFloat(price.innerHTML);
            this.valueTotal = Utils.formatPrice(subtracao);  

        }
    }

    calcThing()//calcular troco thing = troco
    {
        if(this.valueReceived != null && this.valueTotal != null && this.valueTotal != 0){
            this.valueThing = Utils.formatPrice(this.valueReceived - this.valueTotal);
        }
        if(!this.valueThing) Utils.formatPrice(this.valueThing = 0.00);
    }

    returnID(valueStr)
    {
        let id = valueStr.substr(valueStr.length - 1);
        return id;
    }

    returnOP(valueStr)
    {
        let op = valueStr.substr(0, valueStr.indexOf("-"));
        return op;
    }
    
    addEventListenerAll(element, events, fn)
    {
        events.split(" ").forEach(event=>{
            element.addEventListener(event, fn, false);
        });
    }

    removeLast(id)
    {
        let last = document.getElementById(id);
        last.classList.remove("active");
    }
    //Inicio Metodos de Sessão ------------------------------------>
    addListProducts(id, qtd)
    {
        if(this._listIDProducts.length > 0){
            let existe = false;
            for(let i = 0; i < this._listIDProducts.length; i++){

                if(this._listIDProducts[i].idproduct == id){

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

    insertForSession()
    {
        let dataProducts = [];
        
        if(sessionStorage.getItem("products")){
            
            let json = JSON.parse(sessionStorage.getItem("products"));

           
        }
        dataProducts.push(this._listIDProducts); 
        sessionStorage.setItem("products", JSON.stringify(dataProducts));

    }

    chargeSession()
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
    }

    setCalcValueTotalSession(id, qtd)
    {
        let price = document.querySelector(`#price-${id}`);

        let operation = parseFloat(qtd) * parseFloat(price.innerHTML);

        if(this.valueTotal > 0) operation = parseFloat(operation) + Utils.formatToFloat(this.valueTotal);

        this.valueTotal = Utils.formatPrice(operation);  
            
    }
    //fim metodos de sessão -------------------->
    

}