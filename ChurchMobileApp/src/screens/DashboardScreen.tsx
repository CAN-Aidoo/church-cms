import React, { useContext } from 'react';
import {
  View,
  Text,
  StyleSheet,
  TouchableOpacity,
  SafeAreaView,
  StatusBar,
  ScrollView,
  ImageBackground,
  Dimensions
} from 'react-native';
import { AuthContext } from '../context/AuthContext';

const { width } = Dimensions.get('window');

// Placeholder SVGs can be handled by a distinct component library or png assets
// Since we don't have react-native-svg setup guaranteed, we'll use Emoji/Text for icons
// or View blocks.

const DashboardScreen = () => {
  const { user, logout } = useContext(AuthContext);

  const getGreeting = () => {
    const hours = new Date().getHours();
    if (hours < 12) return 'Good morning';
    if (hours < 18) return 'Good afternoon';
    return 'Good evening';
  };

  const getInitials = (name: string) => {
    return name
      .split(' ')
      .map((n) => n[0])
      .join('')
      .substring(0, 2)
      .toUpperCase();
  };

  const userName = user?.member?.first_name || user?.name || 'Member';
  const userInitials = getInitials(userName);

  return (
    <View style={styles.container}>
      <StatusBar barStyle="light-content" backgroundColor="#2563eb" />

      {/* Curved Header Background */}
      <View style={styles.headerBackground}>
        {/* Abstract shapes simulation */}
        <View style={styles.headerShape1} />
        <View style={styles.headerShape2} />
      </View>

      <SafeAreaView style={styles.safeArea}>
        <View style={styles.headerContent}>
          <View>
            <Text style={styles.greetingSub}>{getGreeting()},</Text>
            <Text style={styles.greetingTitle}>{userName}</Text>
          </View>
          <View style={styles.avatarContainer}>
            <Text style={styles.avatarText}>{userInitials}</Text>
          </View>
        </View>

        {/* Floating Quick Stats - overlapping the header */}
        <View style={styles.statsContainer}>
          <View style={styles.statCard}>
            <Text style={styles.statValue}>--</Text>
            <Text style={styles.statLabel}>ATTENDED</Text>
          </View>
          <View style={styles.statDivider} />
          <View style={styles.statCard}>
            <Text style={styles.statValue}>--</Text>
            <Text style={styles.statLabel}>GIVEN</Text>
          </View>
          <View style={styles.statDivider} />
          <View style={styles.statCard}>
            <Text style={styles.statValue}>--</Text>
            <Text style={styles.statLabel}>EVENTS</Text>
          </View>
        </View>

        <ScrollView
          contentContainerStyle={styles.scrollContent}
          showsVerticalScrollIndicator={false}
        >
          {/* Quick Actions Grid */}
          <Text style={styles.sectionTitle}>QUICK ACTIONS</Text>
          <View style={styles.grid}>
            <TouchableOpacity style={styles.actionCard}>
              <View style={[styles.iconBox, { backgroundColor: '#e0e7ff' }]}>
                {/* Icon Placeholder: Check In */}
                <Text style={{ fontSize: 24 }}>📍</Text>
              </View>
              <Text style={styles.actionText}>Check In</Text>
            </TouchableOpacity>

            <TouchableOpacity style={styles.actionCard}>
              <View style={[styles.iconBox, { backgroundColor: '#dcfce7' }]}>
                {/* Icon Placeholder: Give */}
                <Text style={{ fontSize: 24 }}>💰</Text>
              </View>
              <Text style={styles.actionText}>Give</Text>
            </TouchableOpacity>

            <TouchableOpacity style={styles.actionCard}>
              <View style={[styles.iconBox, { backgroundColor: '#f3e8ff' }]}>
                {/* Icon Placeholder: QR */}
                <Text style={{ fontSize: 24 }}>📱</Text>
              </View>
              <Text style={styles.actionText}>My QR</Text>
            </TouchableOpacity>

            <TouchableOpacity style={styles.actionCard}>
              <View style={[styles.iconBox, { backgroundColor: '#fef3c7' }]}>
                {/* Icon Placeholder: Events */}
                <Text style={{ fontSize: 24 }}>📅</Text>
              </View>
              <Text style={styles.actionText}>Events</Text>
            </TouchableOpacity>
          </View>

          {/* Announcements Section */}
          <View style={styles.sectionHeader}>
            <Text style={styles.sectionTitle}>ANNOUNCEMENTS</Text>
            <TouchableOpacity>
              <Text style={styles.seeAllText}>See All</Text>
            </TouchableOpacity>
          </View>

          <ScrollView
            horizontal
            showsHorizontalScrollIndicator={false}
            contentContainerStyle={styles.announcementsContainer}
          >
            {[1, 2].map((i) => (
              <View key={i} style={styles.announcementCard}>
                <View style={styles.urgentDot} />
                <Text style={styles.announcementTitle}>Mid-week Service Today</Text>
                <Text style={styles.announcementBody} numberOfLines={2}>
                  Join us this evening for a powerful time of prayer and word...
                </Text>
                <Text style={styles.announcementDate}>Today</Text>
              </View>
            ))}
          </ScrollView>

          {/* Service Times */}
          <Text style={[styles.sectionTitle, { marginTop: 24 }]}>SERVICE TIMES</Text>
          <View style={styles.serviceCard}>
            {[
              { day: 'Sunday', time: '7:00 AM', label: '1st Service' },
              { day: 'Sunday', time: '9:30 AM', label: '2nd Service' },
              { day: 'Wednesday', time: '6:00 PM', label: 'Midweek Service' }
            ].map((s, index) => (
              <View key={index} style={[styles.serviceRow, index === 2 && { borderBottomWidth: 0 }]}>
                <View>
                  <Text style={styles.serviceDay}>{s.day}</Text>
                  <Text style={styles.serviceLabel}>{s.label}</Text>
                </View>
                <View style={styles.timeBadge}>
                  <Text style={styles.timeText}>{s.time}</Text>
                </View>
              </View>
            ))}
          </View>

          <TouchableOpacity style={styles.logoutButton} onPress={logout}>
            <Text style={styles.logoutText}>Log Out</Text>
          </TouchableOpacity>

          <View style={{ height: 40 }} />
        </ScrollView>
      </SafeAreaView>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f8fafc',
  },
  safeArea: {
    flex: 1,
  },
  headerBackground: {
    position: 'absolute',
    top: 0,
    left: 0,
    right: 0,
    height: 280, // Talle header background
    backgroundColor: '#2563eb',
    borderBottomLeftRadius: 40,
    borderBottomRightRadius: 40,
    overflow: 'hidden',
  },
  headerShape1: {
    position: 'absolute',
    top: -50,
    left: -50,
    width: 200,
    height: 200,
    borderRadius: 100,
    backgroundColor: '#ffffff',
    opacity: 0.1,
  },
  headerShape2: {
    position: 'absolute',
    top: 100,
    right: -20,
    width: 150,
    height: 150,
    borderRadius: 75,
    backgroundColor: '#93c5fd', // blue-300
    opacity: 0.2,
  },
  headerContent: {
    paddingHorizontal: 24,
    paddingTop: 20,
    paddingBottom: 30, // Extra padding for stats overlap
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
  },
  greetingSub: {
    color: '#bfdbfe', // blue-200
    fontSize: 14,
    fontWeight: '600',
    marginBottom: 2,
  },
  greetingTitle: {
    color: '#ffffff',
    fontSize: 24,
    fontWeight: 'bold',
  },
  avatarContainer: {
    width: 50,
    height: 50,
    borderRadius: 25,
    backgroundColor: 'rgba(255, 255, 255, 0.2)',
    borderWidth: 1,
    borderColor: 'rgba(255, 255, 255, 0.3)',
    justifyContent: 'center',
    alignItems: 'center',
  },
  avatarText: {
    color: '#fff',
    fontSize: 18,
    fontWeight: 'bold',
  },
  statsContainer: {
    flexDirection: 'row',
    backgroundColor: 'rgba(255, 255, 255, 0.15)', // Glass effect
    marginHorizontal: 24,
    borderRadius: 20,
    padding: 16,
    justifyContent: 'space-between',
    borderWidth: 1,
    borderColor: 'rgba(255, 255, 255, 0.2)',
    marginBottom: 10,
  },
  statCard: {
    alignItems: 'center',
    flex: 1,
  },
  statValue: {
    fontSize: 20,
    fontWeight: 'bold',
    color: '#fff',
    marginBottom: 4,
  },
  statLabel: {
    fontSize: 10,
    color: '#bfdbfe',
    fontWeight: '700',
    letterSpacing: 0.5,
  },
  statDivider: {
    width: 1,
    backgroundColor: 'rgba(255, 255, 255, 0.2)',
    height: '80%',
    alignSelf: 'center',
  },
  scrollContent: {
    paddingTop: 24,
    paddingHorizontal: 24,
  },
  sectionHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 16,
    marginTop: 24,
  },
  sectionTitle: {
    fontSize: 12,
    fontWeight: '700',
    color: '#94a3b8', // slate-400
    letterSpacing: 1,
  },
  seeAllText: {
    color: '#2563eb',
    fontSize: 13,
    fontWeight: '600',
  },
  grid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: 16,
    marginTop: 16,
    justifyContent: 'space-between',
  },
  actionCard: {
    width: (width - 48 - 16) / 2, // calculate exact width based on padding and gap
    backgroundColor: '#fff',
    padding: 16,
    borderRadius: 20,
    alignItems: 'center',
    shadowColor: '#64748b',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.05,
    shadowRadius: 10,
    elevation: 2,
    marginBottom: 0,
  },
  iconBox: {
    width: 56,
    height: 56,
    borderRadius: 18,
    marginBottom: 12,
    justifyContent: 'center',
    alignItems: 'center',
  },
  actionText: {
    fontSize: 14,
    fontWeight: '600',
    color: '#475569',
  },
  announcementsContainer: {
    gap: 16,
    paddingRight: 24, // padding for last item visibility
  },
  announcementCard: {
    width: 280,
    backgroundColor: '#fff',
    padding: 16,
    borderRadius: 20,
    borderWidth: 1,
    borderColor: '#f1f5f9',
    position: 'relative',
    shadowColor: '#64748b',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.05,
    shadowRadius: 5,
    elevation: 1,
  },
  urgentDot: {
    position: 'absolute',
    top: 16,
    right: 16,
    width: 8,
    height: 8,
    borderRadius: 4,
    backgroundColor: '#ef4444',
  },
  announcementTitle: {
    fontSize: 16,
    fontWeight: '700',
    color: '#1e293b',
    marginBottom: 6,
    paddingRight: 10,
  },
  announcementBody: {
    fontSize: 13,
    color: '#64748b',
    lineHeight: 18,
    marginBottom: 12,
  },
  announcementDate: {
    fontSize: 10,
    fontWeight: '700',
    color: '#94a3b8',
    textTransform: 'uppercase',
  },
  serviceCard: {
    backgroundColor: '#fff',
    borderRadius: 20,
    padding: 20,
    marginTop: 16,
    borderWidth: 1,
    borderColor: '#f1f5f9',
  },
  serviceRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingVertical: 12,
    borderBottomWidth: 1,
    borderBottomColor: '#f1f5f9',
  },
  serviceDay: {
    fontSize: 14,
    fontWeight: '700',
    color: '#334155',
  },
  serviceLabel: {
    fontSize: 12,
    color: '#94a3b8',
    marginTop: 2,
  },
  timeBadge: {
    backgroundColor: '#f1f5f9',
    paddingHorizontal: 12,
    paddingVertical: 6,
    borderRadius: 20,
  },
  timeText: {
    fontSize: 12,
    fontWeight: '700',
    color: '#475569',
  },
  logoutButton: {
    marginTop: 32,
    alignSelf: 'center',
    paddingVertical: 12,
    paddingHorizontal: 32,
    borderRadius: 12,
    backgroundColor: '#f1f5f9',
  },
  logoutText: {
    color: '#64748b',
    fontWeight: '600',
    fontSize: 14,
  },
});

export default DashboardScreen;
