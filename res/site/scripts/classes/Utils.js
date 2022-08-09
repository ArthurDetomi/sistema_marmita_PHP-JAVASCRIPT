class Utils{
    static formatPrice(price)
    {
        return `R$${price.toString().replace(".", ",")}`.substring(0, 6);
    }

    static formatToFloat(price)
    {
        let priceFormat = price.toString().replace("R$","");
        priceFormat = priceFormat.toString().replace(",",".");
        return parseFloat(priceFormat);
    }

    
}