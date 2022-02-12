<template>
    <div class="ff-iban">
        <div class="container">
            <input-field
                :ref=f01.ref
                :pConfig = f01
            ></input-field>
            <input-field
                :ref=f02.ref
                :pConfig = f02
            ></input-field>
            <input-field
                :ref=f03.ref
                :pConfig = f03
            ></input-field>
            <input-field
                :ref=f04.ref
                :pConfig = f04
            ></input-field>
            <input-field
                :ref=f05.ref
                :pConfig = f05
            ></input-field>
            <input-field
                :ref=f06.ref
                :pConfig = f06
            ></input-field>
        </div>
    </div>
</template>
<script>

    import InputField from "./InputField";

	export default {
		name: "my-iban",
        props: {
            pConfig: {type: Object, required: true}
        },
        components: {
            'input-field': InputField
        },
        created() {
            this.mask ='XXXX';
		    this.f01 = this.cfg01();
            this.f02 = this.cfg02();
            this.f03 = this.cfg03();
            this.f04 = this.cfg04();
            this.f05 = this.cfg05();
            this.f06 = this.cfg06();
        },
		directives:{},
		mounted() {
        },
        methods: {
			getValue: function () {
			    let sir =   this.$refs[this.f01.ref].getValue()+
                            this.$refs[this.f02.ref].getValue()+
                            this.$refs[this.f03.ref].getValue()+
                            this.$refs[this.f04.ref].getValue()+
                            this.$refs[this.f05.ref].getValue()+
                            this.$refs[this.f06.ref].getValue();

			    return sir;
			},
            setValue: function (val) {
			    this.resetValue();

			    let arrayValue = this.$string.splitStringIn(val, 4);
			    for (let i=0; i< arrayValue.length; i++){
			        if(i == 0){
			            this.$refs[this.f01.ref].setValue(arrayValue[i]);
                    } else if(i == 1){
                        this.$refs[this.f02.ref].setValue(arrayValue[i]);
                    } else if(i == 2){
                        this.$refs[this.f03.ref].setValue(arrayValue[i]);
                    } else if(i == 3){
                        this.$refs[this.f04.ref].setValue(arrayValue[i]);
                    } else if(i == 4){
                        this.$refs[this.f05.ref].setValue(arrayValue[i]);
                    } else if(i == 5){
                        this.$refs[this.f06.ref].setValue(arrayValue[i]);
                    }
                }
            },
	        resetValue: function () {
                this.$refs[this.f01.ref].setValue('');
                this.$refs[this.f02.ref].setValue('');
                this.$refs[this.f03.ref].setValue('');
                this.$refs[this.f04.ref].setValue('');
                this.$refs[this.f05.ref].setValue('');
                this.$refs[this.f06.ref].setValue('');
	        },
	        keydownPress: function () {
	        },
            cfg01: function(){
                let cfg = this.$app.cfgInputField("f01", 3);
                cfg.setValidate(4,4);
                cfg.setValidateFunction(this.validate01);
                cfg.setCaption('Campul 1');
                cfg.setMandatory(true);
                cfg.setMaska(this.mask);
                return cfg;
            },
            cfg02: function(){
                let cfg = this.$app.cfgInputField("f02", 3);
                cfg.setValidate(4,4);
                cfg.setValidateFunction(this.validate02);
                cfg.setCaption('Campul 2');
                cfg.setMandatory(true);
                cfg.setMaska(this.mask);
                return cfg;
            },
            cfg03: function(){
                let cfg = this.$app.cfgInputField("f03", 3);
                cfg.setValidate(4,4);
                cfg.setValidateFunction(this.validate03);
                cfg.setCaption('Campul 3');
                cfg.setMandatory(true);
                cfg.setMaska(this.mask);
                return cfg;
            },
            cfg04: function(){
                let cfg = this.$app.cfgInputField("f04", 3);
                cfg.setValidate(4,4);
                cfg.setValidateFunction(this.validate04);
                cfg.setCaption('Campul 4');
                cfg.setMandatory(true);
                cfg.setMaska(this.mask);
                return cfg;
            },
            cfg05: function(){
                let cfg = this.$app.cfgInputField("f05", 3);
                cfg.setValidate(4,4);
                cfg.setValidateFunction(this.validate05);
                cfg.setCaption('Campul 5');
                cfg.setMandatory(true);
                cfg.setMaska(this.mask);
                return cfg;
            },
            cfg06: function(){
                let cfg = this.$app.cfgInputField("f06", 3);
                cfg.setValidate(4,4);
                cfg.setValidateFunction(this.validate06);
                cfg.setCaption('Campul 6');
                cfg.setMandatory(true);
                cfg.setMaska(this.mask);
                return cfg;
            }
        },
		data () {
			return {
            }
		}
	}
</script>

<style scoped>
</style>


