<template>
    <div class="ff-navbar">
        <ul>
            <!--
            <li><router-link to="/testInvoicesList">Lista test</router-link></li>
            <li><router-link to="/testTab">Tab test</router-link></li>
            <li><router-link to="/badmintonCourt">Badminton court</router-link></li>
            -->
            <li><router-link to="/viewGridul">Gridul</router-link></li>
            <li><router-link to="/testControale">Test controale</router-link></li>
            <li class="li-right" v-on:click="mLogout"> <a href="javascript:void(null);">Logout</a> </li>
            <li class="li-right"><a href="#about">About</a></li>
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
                );
            },
            isLogout: function () {
                return this.logout;
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
