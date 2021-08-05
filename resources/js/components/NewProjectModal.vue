<template>
    <modal name="new-project" classes="modal-reset" height="auto" width="650" @closed="form.setDefault">
        <div class="w-full min-h-full bg-card rounded-lg p-10">
            <form @submit.prevent="submit">
                <h2 class="mb-16 mt-4 text-center text-2xl">Let's Start Something New</h2>

                <div class="flex justify-between mb-4">
                    <div class="mr-4 w-1/2">
                        <div class="mb-4">
                            <label for="title" class="text-sm block mb-2">Title</label>
                            <input
                                name="title" id="title" v-model="form.data.title"
                                class="input w-full" placeholder="My New Project" type="text"
                                :class="form.errors.title ? 'is-invalid' : ''">
                            <span class="text-xs text-red-500" v-if="form.errors.title" v-text="form.errors.title[0]"></span>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="text-sm block mb-2">Description</label>
                            <textarea
                                name="description" id="description" v-model="form.data.description"
                                class="input w-full resize-none" placeholder="Short Description..." rows="4"
                                :class="form.errors.description ? 'is-invalid' : ''">
                            ></textarea>
                            <span class="text-xs text-red-500" v-if="form.errors.description" v-text="form.errors.description[0]"></span>

                        </div>
                    </div>

                    <div class="ml-4 w-1/2">
                        <div class="mb-2">
                            <label for="title" class="text-sm block mb-2">Need Some Tasks?</label>
                            <input
                                v-for="task in form.data.tasks"
                                type="text" class="input w-full mb-3"
                                placeholder="New Task"
                                v-model="task.body">
                        </div>

                        <button type="button" class="inline-flex items-center" @click="addTask">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" class="mr-2">
                                <g fill="none" fill-rule="evenodd" opacity=".307">
                                    <path stroke="#000" stroke-opacity=".012" stroke-width="0" d="M-3-3h24v24H-3z"></path>
                                    <path fill="#000" d="M9 0a9 9 0 0 0-9 9c0 4.97 4.02 9 9 9A9 9 0 0 0 9 0zm0 16c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7zm1-11H8v3H5v2h3v3h2v-3h3V8h-3V5z"></path>
                                </g>
                            </svg>

                            <span class="text-sm">Add New Task</span>
                        </button>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="button" class="button mr-4 is-outlined" @click="$modal.hide( 'new-project' )">Cancel</button>
                    <button type="submit" class="button">Add Project</button>
                </div>
            </form>
        </div>
    </modal>
</template>

<script>
import BirdboardForm from '../BirdboardForm.js';

export default {
    name : "NewProjectModal",

    data () {
        return {
            form : new BirdboardForm( {
                title : '',
                description : '',
                tasks : [ { body : '' } ],
            } ),
        };
    },

    methods : {
        addTask () {
            this.form.data.tasks.push( { body : '' } );
        },

        submit () {
            this.form.post( '/projects' )
                .then( response => location = response.data.project_path )
                .catch( () => null );
        },
    },
}
</script>
