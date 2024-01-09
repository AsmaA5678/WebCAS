const mongoose = require('mongoose');
const Schema = mongoose.Schema; 

const activitySchema = new Schema(
    {
        titre: {
            type: String,
            required: true
        },
        date: {
            type: String,
            required: true
        },
        heure: {
            type: String,
            required: true
        },
        localisation: {
            type: String,
            required: true
        },
        description: {
            type: String,
            required: false
        },
    },
    {
        timestamps: true
    }
);

const Activity = mongoose.model('Activity', activitySchema);
module.exports = Activity;