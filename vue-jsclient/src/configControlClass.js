class ConfigControl {
    id = null;
    name = null;
    ref  = null;
    mandatory = false;
    validate = null;     // function form call
    caption= null;
    sizeField= 0;               // lungimea controlului

    setBaseConfig(id, sizeField) {
        this.id = id;
        this.name = id + '_name';
        this.ref = 'ref_' + id;
        this.sizeField = sizeField;
    }
    setCaption(caption) {
        this.caption = caption;
    }
    setValidateFunction(functionName) {
        this.validate = functionName;
    }
    setMandatory(madatory){
        this.mandatory = madatory;
    }

}


class InputField extends ConfigControl
{
    minLength= 0;
    maxLength= 0;
    maska= "";
    placeHolder="..."

    setMaska(maska) {
        this.maska = maska;
    }
    setValidate(min, max) {
        this.minLength = min;
        this.maxLength = max;
    }
    setPlaceHolder(text) {
        this.placeHolder = text;
    }

}


export default class factoryConfigControl {
    static INPUT_FIELD = 'inputField';

    static getConfig(control){
        switch (control)
        {
            case factoryConfigControl.INPUT_FIELD:
                return new InputField();
                break;
            default:
                console.log ("nu exista configurare pentru controlul " + control);
       }



    }

}
