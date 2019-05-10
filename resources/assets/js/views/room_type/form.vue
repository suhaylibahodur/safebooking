<template>
    <form @submit.prevent="proceed">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Name</label>
                    <input class="form-control" type="text" value="" v-model="roomTypeForm.name">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-info waves-effect waves-light m-t-10">
            <span v-if="id">Update</span>
            <span v-else>Save</span>
        </button>
        <router-link to="/roomType" class="btn btn-danger waves-effect waves-light m-t-10" v-show="id">Cancel</router-link>
    </form>
</template>


<script>
    import 'vue-range-slider/dist/vue-range-slider.css'

    export default {
        data() {
            return {
                roomTypeForm: new Form({
                    'name' : '',
                })
            };
        },
        props: ['id'],
        mounted() {
            if(this.id)
                this.getRoomType();
        },
        methods: {
            proceed(){
                if(this.id)
                    this.updateRoomType();
                else
                    this.storeRoomType();
            },
            storeRoomType(){
                this.roomTypeForm.post('/api/room_type')
                .then(response => {
                    toastr['success'](response.message);
                    this.$emit('completed',response.roomType)
                })
                .catch(response => {
                    toastr['error'](response.message);
                });
            },
            getRoomType(){
                axios.get('/api/room_type/'+this.id)
                .then(response => {
                    this.roomTypeForm.name = response.data.name;
                })
                .catch(response => {
                    toastr['error'](response.message);
                });
            },
            updateRoomType(){
                this.roomTypeForm.patch('/api/room_type/'+this.id)
                .then(response => {
                    if(response.type == 'error')
                        toastr['error'](response.message);
                    else {
                        this.$router.push('/room_type');
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
