<template>
    <form @submit.prevent="proceed">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Name</label>
                    <input class="form-control" type="text" value="" v-model="conditionForm.name">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-info waves-effect waves-light m-t-10">
            <span v-if="id">Update</span>
            <span v-else>Save</span>
        </button>
        <router-link to="/condition" class="btn btn-danger waves-effect waves-light m-t-10" v-show="id">Cancel</router-link>
    </form>
</template>


<script>
    import 'vue-range-slider/dist/vue-range-slider.css'

    export default {
        data() {
            return {
                conditionForm: new Form({
                    'name' : '',
                })
            };
        },
        props: ['id'],
        mounted() {
            if(this.id)
                this.getCondition();
        },
        methods: {
            proceed(){
                if(this.id)
                    this.updateCondition();
                else
                    this.storeCondition();
            },
            storeCondition(){
                this.conditionForm.post('/api/condition')
                .then(response => {
                    toastr['success'](response.message);
                    this.$emit('completed',response.condition)
                })
                .catch(response => {
                    toastr['error'](response.message);
                });
            },
            getCondition(){
                axios.get('/api/condition/'+this.id)
                .then(response => {
                    this.conditionForm.name = response.data.name;
                })
                .catch(response => {
                    toastr['error'](response.message);
                });
            },
            updateCondition(){
                this.conditionForm.patch('/api/condition/'+this.id)
                .then(response => {
                    if(response.type == 'error')
                        toastr['error'](response.message);
                    else {
                        this.$router.push('/condition');
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
