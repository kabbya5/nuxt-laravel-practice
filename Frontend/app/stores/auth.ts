import {defineStore} from 'pinia';

interface User{
    id:number,
    name:string,
    email:string,
}

export const useAuthStore = defineStore('auth',{
    state:() => ({
        user: null as User | null,
    }),

    actions:{
        async initAuth(){
            try{
                const res:any = await useApiFetch('/user2');
                if(res){
                    this.user = res;
                }
            }catch{
                this.user = null
            }
        },

        async register(formData :any){
            try{
                const res:any = await useApiFetch('/register',{
                    method:'POST',
                    body:formData,
                });

                if(res.user){
                    this.user = res.user;
                }
            }catch(err){
                throw err;
            }
        },
        async login(formData:any){
            try{
                const res:any = await useApiFetch('/register',{
                    method:'POST',
                    body:formData,
                });

                if(res.user){
                    this.user = res.user
                }
            }catch(err){
                throw err;
            }
        },

        async logout() {
            await useApiFetch('/logout', {
                method: 'POST',
            })

            this.user = null
        },
    }
});