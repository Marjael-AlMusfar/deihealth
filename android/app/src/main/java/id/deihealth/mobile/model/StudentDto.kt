package id.deihealth.mobile.model

data class StudentDto(
    val id: Long,
    val nis: String,
    val name: String,
    val gender: String,
    val className: String?,
    val dormitory: String?,
    val guardianName: String?,
    val guardianPhone: String?,
)
