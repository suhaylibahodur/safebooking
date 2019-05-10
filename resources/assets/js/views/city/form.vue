<template>
    <form @submit.prevent="proceed">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Name</label>
                    <input class="form-control" type="text" value="" v-model="cityForm.name">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-info waves-effect waves-light m-t-10">
            <span v-if="id">Update</span>
            <span v-else>Save</span>
        </button>
        <router-link to="/city" class="btn btn-danger waves-effect waves-light m-t-10" v-show="id">Cancel</router-link>
    </form>
</template>


<script>
    import 'vue-range-slider/dist/vue-range-slider.css'

    export default {
        data() {
            return {
                cityForm: new Form({
                    'name' : '',
                })
            };
        },
        props: ['id'],
        mounted() {
            if(this.id)
                this.getCity();
        },
        methods: {
            proceed(){
                if(this.id)
                    this.updateCity();
                else
                    this.storeCity();
            },
            storeCity(){
                this.cityForm.post('/api/city')
                .then(response => {
                    toastr['success'](response.message);
                    this.$emit('completed',response.city)
                })
                .catch(response => {
                    toastr['error'](response.message);
                });
            },
            getCity(){
                axios.get('/api/city/'+this.id)
                .then(response => {
                    this.cityForm.name = response.data.name;
                })
                .catch(response => {
                    toastr['error'](response.message);
                });
            },
            updateCity(){
                this.cityForm.patch('/api/city/'+this.id)
                .then(response => {
                    if(response.type == 'error')
                        toastr['error'](response.message);
                    else {
                        this.$router.push('/city');
                    }
                })
                .catch(response => {
                    toastr['error'](response.message);
                });
            }
        }
    }
</script>
<style>
    .slider{
        width: 100%;
    }
</style>
