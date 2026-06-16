package id.deihealth.mobile.model

import com.squareup.moshi.Json

data class StudentDto(
    val id: Long,
    val nis: String,
    val name: String,
    val gender: String,
    @Json(name = "class_name") val className: String?,
    val dormitory: String?,
    @Json(name = "guardian_name") val guardianName: String?,
    @Json(name = "guardian_phone") val guardianPhone: String?,
)
