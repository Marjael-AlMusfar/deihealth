package id.deihealth.mobile

import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.foundation.verticalScroll
import androidx.compose.material3.Button
import androidx.compose.material3.Card
import androidx.compose.material3.CircularProgressIndicator
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.OutlinedTextField
import androidx.compose.material3.Surface
import androidx.compose.material3.Text
import androidx.compose.material3.TextButton
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.rememberCoroutineScope
import androidx.compose.runtime.setValue
import androidx.compose.ui.Modifier
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.text.input.PasswordVisualTransformation
import androidx.compose.ui.unit.dp
import id.deihealth.mobile.api.ApiClient
import id.deihealth.mobile.api.DeiHealthApi
import id.deihealth.mobile.model.CreateHealthReportRequest
import id.deihealth.mobile.model.LoginRequest
import id.deihealth.mobile.model.RegisterRequest
import kotlinx.coroutines.launch

class MainActivity : ComponentActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContent {
            MaterialTheme {
                Surface(modifier = Modifier.fillMaxSize()) {
                    DeiHealthApp()
                }
            }
        }
    }
}

@Composable
fun DeiHealthApp() {
    var baseUrl by remember { mutableStateOf("http://10.0.2.2:8000/") }
    var token by remember { mutableStateOf<String?>(null) }
    val api = remember(baseUrl, token) { ApiClient.create(baseUrl, token) }

    if (token == null) {
        AuthScreen(baseUrl = baseUrl, onBaseUrlChange = { baseUrl = it }, api = api, onLoggedIn = { token = it })
    } else {
        HomeScreen(api = api, onLogout = { token = null })
    }
}

@Composable
private fun AuthScreen(baseUrl: String, onBaseUrlChange: (String) -> Unit, api: DeiHealthApi, onLoggedIn: (String) -> Unit) {
    var mode by remember { mutableStateOf("login") }
    var name by remember { mutableStateOf("") }
    var email by remember { mutableStateOf("admin@deihealth.local") }
    var password by remember { mutableStateOf("password123") }
    var role by remember { mutableStateOf("musyrif") }
    var message by remember { mutableStateOf("Masuk sebagai admin seeder atau daftar user baru untuk approval.") }
    var loading by remember { mutableStateOf(false) }
    val scope = rememberCoroutineScope()

    Column(modifier = Modifier.padding(20.dp).verticalScroll(rememberScrollState()), verticalArrangement = Arrangement.spacedBy(12.dp)) {
        Text("DeiHealth", style = MaterialTheme.typography.headlineMedium)
        Text("Monitoring santri sakit dan manajemen obat", style = MaterialTheme.typography.bodyMedium)
        OutlinedTextField(value = baseUrl, onValueChange = onBaseUrlChange, label = { Text("Base URL API") }, modifier = Modifier.fillMaxWidth())
        Row(horizontalArrangement = Arrangement.spacedBy(8.dp)) {
            TextButton(onClick = { mode = "login" }) { Text("Login") }
            TextButton(onClick = { mode = "register" }) { Text("Register") }
        }
        if (mode == "register") {
            OutlinedTextField(value = name, onValueChange = { name = it }, label = { Text("Nama") }, modifier = Modifier.fillMaxWidth())
            OutlinedTextField(value = role, onValueChange = { role = it }, label = { Text("Role") }, modifier = Modifier.fillMaxWidth())
        }
        OutlinedTextField(value = email, onValueChange = { email = it }, label = { Text("Email") }, modifier = Modifier.fillMaxWidth())
        OutlinedTextField(
            value = password,
            onValueChange = { password = it },
            label = { Text("Password") },
            visualTransformation = PasswordVisualTransformation(),
            modifier = Modifier.fillMaxWidth(),
        )
        Button(
            enabled = !loading,
            onClick = {
                loading = true
                scope.launch {
                    runCatching {
                        if (mode == "login") {
                            api.login(LoginRequest(email = email, password = password, deviceName = "android"))
                        } else {
                            api.register(RegisterRequest(name = name, email = email, password = password, role = role))
                            null
                        }
                    }.onSuccess { response ->
                        if (response == null) {
                            message = "Registrasi berhasil. Tunggu approval admin sebelum login."
                        } else {
                            onLoggedIn(response.token)
                        }
                    }.onFailure { message = it.message ?: "Terjadi kesalahan" }
                    loading = false
                }
            },
            modifier = Modifier.fillMaxWidth(),
        ) { Text(if (mode == "login") "Login" else "Register") }
        if (loading) CircularProgressIndicator()
        Text(message)
    }
}

@Composable
private fun HomeScreen(api: DeiHealthApi, onLogout: () -> Unit) {
    var message by remember { mutableStateOf("Siap digunakan.") }
    var studentId by remember { mutableStateOf("") }
    var symptom by remember { mutableStateOf("") }
    var temperature by remember { mutableStateOf("") }
    var medicines by remember { mutableStateOf("Belum dimuat") }
    var reports by remember { mutableStateOf("Belum dimuat") }
    var loading by remember { mutableStateOf(false) }
    val scope = rememberCoroutineScope()

    Column(modifier = Modifier.padding(20.dp).verticalScroll(rememberScrollState()), verticalArrangement = Arrangement.spacedBy(12.dp)) {
        Row(modifier = Modifier.fillMaxWidth(), horizontalArrangement = Arrangement.SpaceBetween) {
            Text("Dashboard Petugas", style = MaterialTheme.typography.headlineSmall)
            TextButton(onClick = onLogout) { Text("Logout") }
        }
        Card(modifier = Modifier.fillMaxWidth()) {
            Column(modifier = Modifier.padding(16.dp), verticalArrangement = Arrangement.spacedBy(8.dp)) {
                Text("Buat Laporan Santri Sakit", style = MaterialTheme.typography.titleMedium)
                OutlinedTextField(value = studentId, onValueChange = { studentId = it }, label = { Text("ID Santri") }, keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Number), modifier = Modifier.fillMaxWidth())
                OutlinedTextField(value = symptom, onValueChange = { symptom = it }, label = { Text("Gejala utama") }, modifier = Modifier.fillMaxWidth())
                OutlinedTextField(value = temperature, onValueChange = { temperature = it }, label = { Text("Suhu") }, keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Decimal), modifier = Modifier.fillMaxWidth())
                Button(onClick = {
                    loading = true
                    scope.launch {
                        runCatching {
                            api.createHealthReport(
                                CreateHealthReportRequest(
                                    studentId = studentId.toLong(),
                                    reportedBy = "Android Petugas",
                                    mainSymptom = symptom,
                                    temperature = temperature.toDoubleOrNull(),
                                    urgency = "sedang",
                                )
                            )
                        }.onSuccess { message = "Laporan sakit berhasil dibuat #${it.id}" }
                            .onFailure { message = it.message ?: "Gagal membuat laporan" }
                        loading = false
                    }
                }, modifier = Modifier.fillMaxWidth()) { Text("Kirim Laporan") }
            }
        }
        Row(horizontalArrangement = Arrangement.spacedBy(8.dp)) {
            Button(onClick = {
                scope.launch {
                    runCatching { api.medicines(lowStock = false) }
                        .onSuccess { medicines = it.data.joinToString("\n") { medicine -> "${medicine.name}: ${medicine.currentStock} ${medicine.unit}" } }
                        .onFailure { medicines = it.message ?: "Gagal memuat obat" }
                }
            }) { Text("Obat") }
            Button(onClick = {
                scope.launch {
                    runCatching { api.healthReports() }
                        .onSuccess { reports = it.data.joinToString("\n") { report -> "#${report.id} ${report.mainSymptom} (${report.status})" } }
                        .onFailure { reports = it.message ?: "Gagal memuat laporan" }
                }
            }) { Text("Laporan") }
        }
        if (loading) CircularProgressIndicator()
        Text(message)
        Spacer(Modifier.height(8.dp))
        Text("Daftar Obat", style = MaterialTheme.typography.titleMedium)
        Text(medicines)
        Text("Laporan Sakit", style = MaterialTheme.typography.titleMedium)
        Text(reports)
    }
}
