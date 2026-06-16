package id.deihealth.mobile.model

data class HealthReportDto(
    val id: Long,
    val studentId: Long,
    val reportedBy: String,
    val reportedAt: String,
    val mainSymptom: String,
    val temperature: Double?,
    val urgency: String,
    val location: String?,
    val status: String,
)

data class CreateHealthReportRequest(
    val studentId: Long,
    val reportedBy: String,
    val mainSymptom: String,
    val symptoms: List<String> = emptyList(),
    val temperature: Double? = null,
    val urgency: String = "rendah",
    val location: String? = null,
)
