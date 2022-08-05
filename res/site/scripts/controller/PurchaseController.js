class PurchaseController{
    constructor()
    {
        this._quantidadep = document.querySelector("#setQtdProduct-5");
        this.initialize();
        
    }
    initialize()
    {
        this.quantidadeTotal_P = 10;
    }

    alterQtdProduct(option)
    {
        if(option === "up"){
            
        }
    }

    addEventListenerAll(element, events, fn)
    {
        events.split(" ").forEach(event => {
            element.addEventListener(event, fn, false);
        });
    }

    initButtonsEevnts()
    {
        let buttons = document.querySelectorAll(".botoes-js > input");
        buttons.forEach(());
    }

    set quantidadeTotal_P(value)
    {
        this._quantidade.value = value; 
    }
    get quantidadeTotal_P()
    {
        return this._quantidade.value;
    }
}