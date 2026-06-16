package id.deihealth.mobile.model

import com.squareup.moshi.Json

data class HealthReportDto(
    val id: Long,
    @Json(name = "student_id") val studentId: Long,
    @Json(name = "reported_by") val reportedBy: String,
    @Json(name = "reported_at") val reportedAt: String,
    @Json(name = "main_symptom") val mainSymptom: String,
    val temperature: Double?,
    val urgency: String,
    val location: String?,
    val status: String,
)

data class CreateHealthReportRequest(
    @Json(name = "student_id") val studentId: Long,
    @Json(name = "reported_by") val reportedBy: String,
    @Json(name = "main_symptom") val mainSymptom: String,
    val symptoms: List<String> = emptyList(),
    val temperature: Double? = null,
    val urgency: String = "rendah",
    val location: String? = null,
)
