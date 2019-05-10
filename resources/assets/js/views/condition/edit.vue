<template>
    <div>
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Edit Condition</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                    <li class="breadcrumb-item"><router-link to="/condition">Condition</router-link></li>
                    <li class="breadcrumb-item active">Edit Condition</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Condition</h4>
                        <condition-form :id="id"></condition-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ConditionForm from './form';
    import helper from '../../services/helper'

    export default {
        components : { ConditionForm },
        data() {
            return {
                id:this.$route.params.id
            }
        }
    }
</script>