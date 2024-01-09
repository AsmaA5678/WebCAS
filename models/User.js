const mongoose = require('mongoose');
const Schema = mongoose.Schema; 

const userSchema = new Schema(
    {
        nom: {
            type: String,
            required: true
        },
        prenom: {
            type: String,
            required: true
        },
        filiere: {
            type: String,
            required: true
        },
        ine: {
            type: Number,
            required: true
        },
        email: {
            type: String,
            required: true
        },
        telephone: {
            type: Number,
            required: true
        },
        score: {
            type: Number,
            required: true
        },
        password: {
            type: String,
            required: true
        },
        username: {
            type: String,
            required: true
        },
    },
    {
        timestamps: true
    }
);

const User = mongoose.model('User', userSchema);
module.exports = User;