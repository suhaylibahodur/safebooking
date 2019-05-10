<template>
    <div>
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Edit City</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                    <li class="breadcrumb-item"><router-link to="/city">City</router-link></li>
                    <li class="breadcrumb-item active">Edit City</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit City</h4>
                        <city-form :id="id"></city-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CityForm from './form';
    import helper from '../../services/helper'

    export default {
        components : { CityForm },
        data() {
            return {
                id:this.$route.params.id
            }
        }
    }
</script>