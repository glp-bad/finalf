<template>
    <div class="ff-navbar">
        <ul>
            <li :idPk="1"><div class="divShow">
                <router-link to="/viewAvocat"    @click="this.headerLink($event)">Avocatul</router-link></div></li>
            <li :idPk="2"><div class="divShow">
                <router-link to="/viewParteneri" @click="this.headerLink($event)">Parteneri</router-link></div></li>
            <li :idPk="3"><div class="divShow">
                <router-link to="/viewInvoices"  @click="this.headerLink($event)">Facturez</router-link></div></li>
            <!--
            <li><router-link to="/viewGridul">Gridul</router-link></li>
            <li><router-link to="/testControale">Test controale</router-link></li>
            -->
            <li :idPk="20" class="li-right" v-on:click="mLogout"><div class="divShow"> <a href="javascript:void(null);">Logout</a></div> </li>
            <li :idPk="21" class="li-right"><div class="divShow"><a href="#about">About</a></div></li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "menu-main",
	    created() {
		    this.URI_LOGOUT  = this.$url.getUrl("logout"),
            this.EMIT = 'logoutMenuMain'

	    },
        methods: {
            mLogout : function(){
                this.axios.post(this.URI_LOGOUT).then(
                	(response) => {
                        if(response.data.succes){
                            this.logout = true;
                        }else{
	                        this.logout = false;
                        }
		                this.$emit(this.EMIT);
                    }
                ).catch( (error) => {
                    this.logout = true;
                    this.$emit(this.EMIT);
                })
            },
            isLogout: function () {
                return this.logout;
            },
	        headerLink: function (event){

            	let li = event.target.closest('li');
            	let idSelect = li.getAttribute('idpk');
            	let ul = li.closest('ul');

            	for(let i= 0; i<ul.children.length; i++){
		            let liChange = ul.children[i];

		            if(liChange.getAttribute('idpk') == idSelect){
			            liChange.firstChild.classList.add('select-iem');
                    }else{
			            liChange.firstChild.classList.remove('select-iem');
                    }
                }


		        // event.target.parentNode.classList.add('select-iem');
		        // event.target.parentNode.style.backgroundColor = '#474747';
            	// console.log(event.target.closest('li'));

            }

        },
	    data() {
		    return {
			    logout: false
		    }
	    }
    }
</script>
<style scoped></style>
