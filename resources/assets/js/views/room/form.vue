<template>
    <form @submit.prevent="proceed">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Город</label>
                    <select name="pageLength" class="form-control" v-model="roomForm.city_id">
                        <option v-for="city in cities.data" v-bind:value="city.id">{{city.name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Адрес</label>
                    <input class="form-control" type="text" value="" v-model="roomForm.address">
                </div>
                <div class="form-group">
                    <label for="">Тип</label>
                    <select name="pageLength" class="form-control" v-model="roomForm.type_id">
                        <option v-for="roomType in roomTypes.data" v-bind:value="roomType.id">{{roomType.name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Состояние</label>
                    <select name="pageLength" class="form-control" v-model="roomForm.condition_id">
                        <option v-for="condition in conditions.data" v-bind:value="condition.id">{{condition.name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Площадь</label>
                    <input class="form-control" type="text" value="" v-model="roomForm.area">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-info waves-effect waves-light m-t-10">
            <span v-if="id">Update</span>
            <span v-else>Save</span>
        </button>
        <router-link to="/room" class="btn btn-danger waves-effect waves-light m-t-10" v-show="id">Cancel</router-link>
    </form>
</template>


<script>
    import 'vue-range-slider/dist/vue-range-slider.css'

    export default {
        data() {
            return {
                roomForm: new Form({
                    'city_id': '',
                    'address': '',
                    'type_id': '',
                    'condition_id': '',
                    'area': '',
                }),
                cities: {},
                roomTypes: {},
                conditions: {},
            };
        },
        created() {
            this.getAllInfoForNewRoom();
        },
        props: ['id'],
        mounted() {
            if(this.id)
                this.getRoom();
        },
        methods: {
            proceed(){
                if(this.id)
                    this.updateRoom();
                else
                    this.storeRoom();
            },
            storeRoom(){
                this.roomForm.post('/api/room')
                .then(response => {
                    toastr['success'](response.message);
                    this.$emit('completed',response.room)
                })
                .catch(response => {
                    toastr['error'](response.message);
                });
            },
            getRoom(){
                axios.get('/api/room/'+this.id)
                .then(response => {
                    this.roomForm.city_id = response.data.city_id;
                    this.roomForm.address = response.data.address;
                    this.roomForm.type_id = response.data.type_id;
                    this.roomForm.condition_id = response.data.condition_id;
                    this.roomForm.area = response.data.area;
                })
                .catch(response => {
                    toastr['error'](response.message);
                });
            },
            getAllInfoForNewRoom() {
                axios.get('/api/city?page=1&pageLength=1000&sortBy=name')
                    .then(response => this.cities = response.data );
                axios.get('/api/room_type?page=1&pageLength=1000&sortBy=id&order=asc')
                    .then(response => this.roomTypes = response.data );
                axios.get('/api/condition?page=1&pageLength=1000&sortBy=id&order=asc')
                    .then(response => this.conditions = response.data );
            },
            updateRoom(){
                this.roomForm.patch('/api/room/'+this.id)
                .then(response => {
                    if(response.type == 'error')
                        toastr['error'](response.message);
                    else {
                        this.$router.push('/room');
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
