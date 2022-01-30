export class CheckCuiRo {

    // https://contabcaf.blogspot.com/2012/11/algoritm-de-validare-pentru-cif.html
    // https://contabcaf.blogspot.com/2012/11/algoritm-de-validare-pentru-cnp.html

    cheieControl=[7,5,3,2,1,7,5,3,2];
    cheieControlReverse = [2,3,5,7,1,2,3,5,7];
    maxLength= 10;
    cod = null;

    constructor(cod) {
         this.cod = cod.toString();
     }

     check() {

         // --------------------------------------------------------- out
        if(this.cod.length > this.maxLength || this.cod.length < 1){
            return false;
        }

        let reverse = this.cod.split("").reverse();
        let invalidCode = false;

        let total = 0;
         let cifraControlCod = 0;

        for(let i = 0; i < reverse.length; i++){

             let nrCui = Number(reverse[i]);

             if( isNaN(nrCui) ){
                 invalidCode = true;
                 break;
             }

             if(i == 0){
                 cifraControlCod = nrCui;
             }

             if(i > 0){
                 total = total + (nrCui * this.cheieControlReverse[i-1]);
             }
        }

         // --------------------------------------------------------- out
         if(invalidCode){
             return false;
         }

         let modulo = (total*10) % 11;

         if(modulo == 10){
             modulo = 0;
         }

         if(modulo == cifraControlCod){
             // --------------------------------------------------------- out
             return true;
         }

         // --------------------------------------------------------- out
         return false;
     }

}


export class CheckCnpRo{
    // https://contabcaf.blogspot.com/2012/11/algoritm-de-validare-pentru-cnp.html

    cheieControl = [2,7,9,1,4,6,3,5,8,2,7,9];
    fixLength = 13;
    cod = "";
    codSplit = null;
    constructor(cod) {
        this.cod = cod.toString();
        this.codSplit = this.cod.split("");
    }

    checkFirstDigit(nr){
        if( (nr < 1 || nr > 6) && nr != 9 ){
            return false;
        }
        return true;
    }

    returnMsg(succes, reason){
        return {succes: succes, reason: reason};
    }

    check() {

        // --------------------------------------------------------- out
        if(this.codSplit.length != this.fixLength){
            return this.returnMsg(false,'lungime cod: ' + this.codSplit.length);
        }


        let invalidCode = false;
        let reason = '';
        let total = 0;

        for(let i = 0; i < this.codSplit.length; i++){

            let nr = Number(this.codSplit[i]);
            if( isNaN(nr) ){
                invalidCode = true;
                reason = 'codul trebuie sa contina numai cifre';
                break;
            }

            if(i == 0){
                if(!this.checkFirstDigit(nr)){
                    invalidCode = true;
                    reason = 'primul numar este gresit';
                    break;
                }

            }

            if(i < 12){
                total = total + (nr * this.cheieControl[i]);
            }

        }

        // --------------------------------------------------------- out
        if(invalidCode){
            return this.returnMsg(false,reason);
        }


        let modulo = total % 11;

        if(modulo == 10){
            modulo = 1;
        }

        if(modulo == Number(this.codSplit[12])){
            // --------------------------------------------------------- out
            return this.returnMsg(true,"ok");
        }

        return this.returnMsg(false,"ultima cifra nu corespunde");

    }
}


