class ConfigControl {
    id = null;
    name = null;
    ref  = null;
    mandatory = false;
    validate = null;            // function form call
    caption= null;
    sizeField= 0;               // lungimea controlului, width filed
    defaultValue= null;
    disabled= false;

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
    setDefaultValue(value){
        this.defaultValue = value;
    }
    setDisable(disable){
        this.disabled = disable;
    }

}



class CheckBox extends ConfigControl{}

class SelectSimple extends ConfigControl{
    // defaultValue: {id: 0, text: ''},

    url= '#';
    setUrl(url){
        this.url = url;
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
    static CHECK_BOX   = 'checkBox';
    static SELECT_SIMPLE   = 'selectSimple';

    static getConfig(control){
        switch (control)
        {
            case factoryConfigControl.INPUT_FIELD:
                return new InputField();
                break;
            case factoryConfigControl.CHECK_BOX:
                return new CheckBox();
                break;
            case factoryConfigControl.SELECT_SIMPLE:
                return new SelectSimple();
                break;
            default:
                console.error("!!! ATENTIE !!! nu exista configurare pentru controlul " + control);
       }



    }

}
