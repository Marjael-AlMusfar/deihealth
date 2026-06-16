package id.deihealth.mobile.model

import com.squareup.moshi.Json

data class CreatePrescriptionRequest(
    @Json(name = "prescribed_by") val prescribedBy: String,
    @Json(name = "started_at") val startedAt: String,
    @Json(name = "ended_at") val endedAt: String? = null,
    val notes: String? = null,
    val items: List<CreatePrescriptionItemRequest>,
)

data class CreatePrescriptionItemRequest(
    @Json(name = "medicine_id") val medicineId: Long,
    val dose: String,
    @Json(name = "frequency_per_day") val frequencyPerDay: Int,
    @Json(name = "duration_days") val durationDays: Int,
    val instructions: String? = null,
)

data class DailyObservationRequest(
    @Json(name = "observed_by") val observedBy: String,
    val temperature: Double? = null,
    @Json(name = "symptom_notes") val symptomNotes: String? = null,
    val appetite: String? = null,
    @Json(name = "rest_quality") val restQuality: String? = null,
    @Json(name = "activity_level") val activityLevel: String? = null,
    @Json(name = "medication_compliance") val medicationCompliance: Boolean = false,
    val notes: String? = null,
)
