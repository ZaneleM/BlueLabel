<template>
    <v-app>
        <v-container>
            <v-card>
                <v-card-title>People</v-card-title>
                <v-alert v-if="successMessage" type="success" dismissible>{{ successMessage }}</v-alert>

                <v-card-text>
                    <v-data-table :headers="headers" :items="people" item-key="id">
                        <template v-slot:[`item.actions`]="{ item }">
                            <v-btn color="info mr-2 mb-2" @click="viewPerson(item)" size="small">View</v-btn>
                            <v-btn color="primary mr-2 mb-2" @click="editPerson(item)" size="small">Edit</v-btn>
                            <v-btn color="error mb-2" @click="deletePerson(item)" size="small">Delete</v-btn>
                        </template>
                    </v-data-table>
                    <v-btn color="success" @click="showAddPersonDialog">Add Person</v-btn>
                </v-card-text>
            </v-card>
        </v-container>
        <v-dialog v-model="addEditPersonDialog" max-width="500px">
            <v-card>
                <v-card-title>{{ formMode === 'add' ? 'Add New Person' : 'Edit Person' }}</v-card-title>
                <v-card-text>
                    <v-alert v-if="errorMessage" type="error" dismissible>{{ errorMessage }}</v-alert>
                    <v-form @submit.prevent="submitForm" lazy-validation ref="personForm">
                        <v-text-field v-model="formData.name" label="Name" required :rules="nameRules"></v-text-field>
                        <v-text-field v-model="formData.surname" label="Surname" required :rules="surnameRules"></v-text-field>
                        <v-text-field v-model="formData.id_number" label="ID Number" required :rules="idNumberRules"></v-text-field>
                        <v-text-field v-model="formData.mobile_number" label="Mobile Number" required :rules="mobileNumberRules"></v-text-field>
                        <v-text-field v-model="formData.email" label="Email" required :rules="emailRules"></v-text-field>
                        <v-text-field v-model="formData.birth_date" label="Birth Date" required :rules="birthDateRules"></v-text-field>
                        <v-select v-model="formData.language" item-title="name" item-value="id" :items="languages" label="Language" required :rules="languageRules"></v-select>
                        <v-select v-model="formData.interests" :items="interests" item-title="name" item-value="id" label="Interests" multiple required :rules="interestsRules"></v-select>
                        <v-btn type="submit" color="primary mr-2 mb-2">{{ formMode === 'add' ? 'Add' : 'Update' }}</v-btn>
                        <v-btn color="error" @click="closeAddEditPersonDialog">Cancel</v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-dialog v-model="viewPersonDialog" max-width="500px">
            <v-card>
                <v-card-title class="headline">Person Details</v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <div class="person-detail">
                        <v-row>
                            <v-col cols="4"><span class="font-weight-bold">Name:</span></v-col>
                            <v-col cols="8">{{ selectedPerson.name }}</v-col>
                        </v-row>
                    </div>
                    <div class="person-detail">
                        <v-row>
                            <v-col cols="4"><span class="font-weight-bold">Surname:</span></v-col>
                            <v-col cols="8">{{ selectedPerson.surname }}</v-col>
                        </v-row>
                    </div>
                    <div class="person-detail">
                        <v-row>
                            <v-col cols="4"><span class="font-weight-bold">ID Number:</span></v-col>
                            <v-col cols="8">{{ selectedPerson.id_number }}</v-col>
                        </v-row>
                    </div>
                    <div class="person-detail">
                        <v-row>
                            <v-col cols="4"><span class="font-weight-bold">Mobile Number:</span></v-col>
                            <v-col cols="8">{{ selectedPerson.mobile_number }}</v-col>
                        </v-row>
                    </div>
                    <div class="person-detail">
                        <v-row>
                            <v-col cols="4"><span class="font-weight-bold">Email:</span></v-col>
                            <v-col cols="8">{{ selectedPerson.email }}</v-col>
                        </v-row>
                    </div>
                    <div class="person-detail">
                        <v-row>
                            <v-col cols="4"><span class="font-weight-bold">Birth Date:</span></v-col>
                            <v-col cols="8">{{ selectedPerson.birth_date }}</v-col>
                        </v-row>
                    </div>
                    <div class="person-detail">
                        <v-row>
                            <v-col cols="4"><span class="font-weight-bold">Language:</span></v-col>
                            <v-col cols="8">{{ selectedPerson.language.name }}</v-col>
                        </v-row>
                    </div>
                    <div class="person-detail" v-if="selectedPerson.interests && selectedPerson.interests.length > 0">
                        <v-row>
                            <v-col cols="4"><span class="font-weight-bold">Interests:</span></v-col>
                            <v-col cols="8">
                                <ul class="pl-0">
                                    <li v-for="interest in selectedPerson.interests" :key="interest.id">{{ interest.name }}</li>
                                </ul>
                            </v-col>
                        </v-row>
                    </div>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-btn color="primary" @click="viewPersonDialog = false">Close</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </v-app>
</template>

<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';

export default {
    setup() {
        const people = ref([]);
        const successMessage = ref("");
        const errorMessage = ref("");

        const headers = ref([
            { text: "Name", align: "start", value: "name" },
            { text: "Surname", value: "surname" },
            { text: "ID Number", value: "id_number" },
            { text: "Email", value: "email" },
            { text: "Actions", value: "actions", sortable: false },
        ]);

        const viewPersonDialog = ref(false);
        const selectedPerson = ref(null);

        const addEditPersonDialog = ref(false);
        const formMode = ref('add');
        const formData = ref({
            id: null,
            name: "",
            surname: "",
            id_number: "",
            mobile_number: "",
            email: "",
            birth_date: "",
            language: null,
            interests: [],
        });
        const languages = ref([]);
        const interests = ref([]);

        onMounted(() => {
            fetchPeople();
            fetchLanguages();
            fetchInterests();
        });

        const fetchPeople = () => {
            axios.get('/api/persons')
                .then(response => {
                    people.value = response.data;
                })
                .catch(() => {
                    errorMessage.value = "Failed to fetch people data.";
                });
        };

        const fetchLanguages = () => {
            axios.get('/api/languages')
                .then(response => {
                    languages.value = response.data;
                })
                .catch(() => {
                    errorMessage.value = "Failed to fetch languages data.";
                });
        };

        const fetchInterests = () => {
            axios.get
            ('/api/interests')
                .then(response => {
                    interests.value = response.data;
                })
                .catch(() => {
                    errorMessage.value = "Failed to fetch interests data.";
                });
        };

        const viewPerson = (person) => {
            selectedPerson.value = { ...person };
            viewPersonDialog.value = true;

        };

        const editPerson = (person) => {
            formMode.value = 'edit';
            formData.value = { ...person };
            addEditPersonDialog.value = true;
        };

        const deletePerson = (person) => {
            axios.delete(`/api/persons/${person.id}`)
                .then(() => {
                    successMessage.value = "Person deleted successfully.";
                    fetchPeople();
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        errorMessage.value = "Failed to delete person. Please fix the following errors:";
                        const validationErrors = error.response.data.errors;
                        for (const errorField in validationErrors) {
                            errorMessage.value += `\n- ${validationErrors[errorField][0]}`;
                        }
                    } else {
                        errorMessage.value = "Failed to delete person.";
                    }
                });
        };


        const showAddPersonDialog = () => {
            formMode.value = 'add';
            formData.value = {
                id: null,
                name: "",
                surname: "",
                id_number: "",
                mobile_number: "",
                email: "",
                birth_date: "",
                language: null,
                interests: [],
            };
            addEditPersonDialog.value = true;
        };

        const closeAddEditPersonDialog = () => {
            addEditPersonDialog.value = false;
            errorMessage.value ='';
        };

        const addPerson = () => {
            axios.post('/api/persons', formData.value)
                .then(() => {
                    successMessage.value = "Person added successfully.";
                    closeAddEditPersonDialog();
                    fetchPeople();
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        errorMessage.value = "Failed to add person. Please fix the following errors:";
                        const validationErrors = error.response.data.errors;
                        for (const errorField in validationErrors) {
                            errorMessage.value += `\n- ${validationErrors[errorField][0]}`;
                        }
                    } else {
                        errorMessage.value = "Failed to add person.";
                    }
                });
        };

        const updatePerson = () => {
            axios.put(`/api/persons/${formData.value.id}`, formData.value)
                .then(() => {
                    successMessage.value = "Person updated successfully.";
                    closeAddEditPersonDialog();
                    fetchPeople();
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        errorMessage.value = "Failed to update person. Please fix the following errors:";
                        const validationErrors = error.response.data.errors;
                        for (const errorField in validationErrors) {
                            errorMessage.value += `\n- ${validationErrors[errorField][0]}`;
                        }
                    } else {
                        errorMessage.value = "Failed to update person.";
                    }
                });
        };


        const submitForm = () => {
            if (formMode.value === 'add') {
                addPerson();
            } else {
                updatePerson();
            }
        };

        // Validation rules
        const nameRules = [
            v => !!v || 'Name is required',
        ];

        const surnameRules = [
            v => !!v || 'Surname is required',
        ];

        const idNumberRules = [
            v => !!v || 'ID Number is required',
        ];

        const mobileNumberRules = [
            v => !!v || 'Mobile Number is required',
        ];

        const emailRules = [
            v => !!v || 'Email is required',
            v => /.+@.+\..+/.test(v) || 'Email must be valid',
        ];

        const birthDateRules = [
            v => !!v || 'Birth Date is required',
        ];

        const languageRules = [
            v => !!v || 'Language is required',
        ];

        const interestsRules = [
            v => !!v && v.length > 0 || 'Interests are required',
        ];

        return {
            people,
            successMessage,
            errorMessage,
            headers,
            addEditPersonDialog,
            formMode,
            formData,
            languages,
            interests,
            viewPersonDialog,
            selectedPerson,
            fetchPeople,
            fetchLanguages,
            fetchInterests,
            viewPerson,
            editPerson,
            deletePerson,
            showAddPersonDialog,
            closeAddEditPersonDialog,
            addPerson,
            updatePerson,
            submitForm,
            nameRules,
            surnameRules,
            idNumberRules,
            mobileNumberRules,
            emailRules,
            birthDateRules,
            languageRules,
            interestsRules,
        };
    },
};
</script>

<style scoped>
/* Add custom styles if needed */
</style>
