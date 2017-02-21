<template>
    <div>
        <h2>
            Drafts
        </h2>

        <div class="columns">
            <div v-for="draft in drafts" class="column">
                <div class="box" v-on:click="goToRoom(draft.id)">
                    <h3 class="title is-5">{{ draft.name }}</h3>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {

            return {
                league_id : document.getElementById('league_id').value,
                results: []
            };
        },
        mounted() {
            this.prepareComponent()

            console.log('Component ready.')
        },

        methods: {
            prepareComponent() {
            },

            getLeague(){
                this.$http.get('/api/league/'+ this.league_id)
                    .then(response => {

                        console.log(response)
                    });
            }

        }
    }
</script>


